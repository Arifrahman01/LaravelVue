<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    pagination: {
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
        links: PaginationLink[];
    };
    search?: string;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="mt-4 flex justify-between items-center px-4 py-3 border-t border-gray-200">
        <div class="text-sm text-gray-700">
            Showing {{ props.pagination.from }} to {{ props.pagination.to }} of {{ props.pagination.total }} results
        </div>
        <nav class="flex items-center space-x-2">
            <!-- Previous Button -->
            <Link v-if="props.pagination.current_page > 1"
                  :href="route('companies.index', { 
                    page: props.pagination.current_page - 1,
                    search: props.search || undefined 
                })"
                  class="px-3 py-1 text-sm border rounded-md hover:bg-gray-100">
            Previous
            </Link>
            <span v-else
                  class="px-3 py-1 text-sm border rounded-md text-gray-400 cursor-not-allowed">
                Previous
            </span>
            <!-- Page Numbers -->
            <template v-for="link in props.pagination.links"
                      :key="link.label">
                <Link v-if="link.url && !link.label.includes('Previous') && !link.label.includes('Next')"
                      :href="route('companies.index', { 
                        page: parseInt(link.label),
                        search: props.search || undefined 
                    })"
                      :class="[
                        'px-3 py-1 text-sm border rounded-md',
                        link.active 
                            ? 'bg-primary text-white border-primary' 
                            : 'hover:bg-gray-100'
                    ]">
                <span v-html="link.label"></span>
                </Link>
                <span v-else-if="!link.url && link.label === '...'"
                      class="px-3 py-1 text-sm">
                    ...
                </span>
            </template>
            
            <!-- Next Button -->
            <Link v-if="props.pagination.current_page < props.pagination.last_page"
                  :href="route('companies.index', { 
                    page: props.pagination.current_page + 1,
                    search: props.search || undefined 
                })"
                  class="px-3 py-1 text-sm border rounded-md hover:bg-gray-100">
            Next
            </Link>
            <span v-else
                  class="px-3 py-1 text-sm border rounded-md text-gray-400 cursor-not-allowed">
                Next
            </span>
        </nav>
    </div>
</template>
