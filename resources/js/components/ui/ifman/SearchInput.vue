<script setup lang="ts">
import { ref, watch, defineEmits, defineProps } from 'vue';
import { debounce } from 'lodash';
import Input from '@/components/ui/input/Input.vue';
import Button from '@/components/ui/button/Button.vue';
import { Search, X } from 'lucide-vue-next';

interface Props {
  modelValue: string;
  placeholder?: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue', 'search']);

const search = ref(props.modelValue || '');

const performSearch = debounce(() => {
  emit('search', search.value);
}, 300);

watch(search, (newVal) => {
  emit('update:modelValue', newVal);
  performSearch();
});

const clearSearch = () => {
  search.value = '';
  performSearch();
};
</script>

<template>
  <div class="relative w-full md:max-w-sm">
    <Input
      v-model="search"
      type="text"
      :placeholder="placeholder || 'Search...'"
      class="pl-10 pr-8 w-full"
    />
    <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
    <Button
      v-if="search"
      variant="ghost"
      size="icon"
      class="absolute right-1 top-1/2 -translate-y-1/2 h-7 w-7 text-gray-500 hover:bg-transparent"
      @click="clearSearch"
      aria-label="Clear search"
      title="Clear search"
    >
      <X class="h-4 w-4" />
    </Button>
  </div>
</template>
