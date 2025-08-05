<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import Button from '@/components/ui/button/Button.vue';
import SearchInput from '@/components/ui/ifman/SearchInput.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Rocket, Edit as RocketEditIcon, Trash2 as Trash2Icon } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';

import SimplePagination from '@/components/ui/ifman/SimplePagination.vue'


import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table"

interface Company {
    id: number;
    code: string;
    name: string;
    note: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    companies: { // Ini adalah struktur data pagination dari Laravel
        data: Company[];
        links: PaginationLink[];
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
    };
    filters: {
        search?: string;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Companies',
        href: route('companies.index'),
    },
];
const page = usePage();

const search = ref(props.filters?.search || '');

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this company?')) {
        router.delete(route('companies.destroy', { company: id }), {
            preserveState: true,
            preserveScroll: true,
        });
    }
}

const performSearch = debounce(() => {
    router.get(route('companies.index'), { search: search.value }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}, 300);

watch(search, () => {
    performSearch();
});

const clearSearch = () => {
    search.value = '';
    performSearch();
};
</script>

<template>

    <Head title="Companies List" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Mengurangi padding pada kontainer utama secara keseluruhan -->
        <div class="p-4 md:p-6 lg:p-8">
            <!-- Judul Halaman -->
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Company List</h1>

            <!-- Flash Message -->
            <div v-if="page.props.flash?.message"
                 class="mb-3">
                <Alert class="bg-blue-50 text-blue-800 border-blue-200">
                    <Rocket class="h-4 w-4" />
                    <AlertTitle>Notification!</AlertTitle>
                    <AlertDescription>
                        {{ page.props.flash?.message }}
                    </AlertDescription>
                </Alert>
            </div>

            <!-- Filter/Search Section dan Tombol Create -->
            <div class="flex flex-col md:flex-row items-center justify-between mb-3 gap-4">
                <!-- Search Input -->
                <SearchInput
                    v-model="search"
                    placeholder="Search companies..."
                />

                <!-- Tombol Create Company -->
                <Link :href="route('companies.create')">
                <Button class="w-full md:w-auto">Create Company</Button>
                </Link>
            </div>

            <!-- Tabel Data Perusahaan -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <Table>
                    <TableHeader class="bg-gray-50">
                        <TableRow>
                            <TableHead class="w-[120px] px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Code
                            </TableHead>
                            <TableHead class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </TableHead>
                            <TableHead class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Note
                            </TableHead>
                            <TableHead class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody class="divide-y divide-gray-200">
                        <TableRow v-for="company in props.companies.data"
                                  :key="company.id">
                            <TableCell class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ company.code }}
                            </TableCell>
                            <TableCell class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ company.name }}
                            </TableCell>
                            <TableCell class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{ company.note }}
                            </TableCell>
                            <TableCell class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    class="text-slate-600 hover:text-slate-800"
                                    as="a"
                                    :href="route('companies.edit', { company: company.id })"
                                    title="Edit Company"
                                    aria-label="Edit Company"
                                >
                                    <RocketEditIcon class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    class="text-red-600 hover:text-red-800 ml-2"
                                    @click="handleDelete(company.id)"
                                    title="Delete Company"
                                    aria-label="Delete Company"
                                >
                                    <Trash2Icon class="h-4 w-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="props.companies.data.length === 0">
                            <TableCell colspan="4"
                                       class="text-center py-8 text-gray-500">
                                No Data found.
                            </TableCell>
                        </TableRow>
                    </TableBody>


                </Table>
                <!-- Pagination -->
                <SimplePagination 
                    :pagination="props.companies"
                    :search="search"
                />
            </div>
        </div>
    </AppLayout>
</template>
