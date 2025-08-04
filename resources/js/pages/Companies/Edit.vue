<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head , useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit a Company',
        href: '',
    },
];

interface company {
    id: number;
    code: string;
    name: string;
    note: string;
}
const props = defineProps<{company : company}>();


const form = useForm({
    id: props.company.id, 
    code: props.company.code,
    name: props.company.name,
    note: props.company.note,
 });

 
 const handleSubmit = () => {
    form.put(route('companies.update', { company : props.company}))
 }


</script>

<template>

    <Head title="Edit a Company" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4 ">
                <div class="space-y-2">
                    <Label for="Company Code">Code</Label>
                    <Input v-model="form.code" type="text" placeholder="Enter Company Code" />
                    <div v-if="form.errors.code" class="text-sm text-red-600">{{ form.errors.code }}</div>
                </div>
                <div class="space-y-2">
                    <Label for="Name">Name</Label>
                    <Input v-model="form.name" type="text" placeholder="Enter Company Name" />
                    <div v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</div>
                </div>
                <div class="space-y-2">
                    <Label for="Note">Note</Label>
                    <Input v-model="form.note" type="text" placeholder="Enter a note" />
                    <div v-if="form.errors.note" class="text-sm text-red-600">{{ form.errors.note }}</div>
                </div>
                <Button type="submit" :disabled="form.processing" >Update</Button>
            </form>
        </div>
    </AppLayout>
</template>
