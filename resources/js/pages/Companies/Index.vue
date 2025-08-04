<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Rocket, Search, X } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';

import {
    Table,
    TableBody,
    TableCaption,
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

interface Props {
    companies: Company[];
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

// Safely access props.filters.search by using optional chaining
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

watch(search, (newSearchTerm) => {
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
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">Company List</h1>

            <!-- Flash Message -->
            <div v-if="page.props.flash?.message" class="mb-4">
                <Alert class="bg-blue-50 text-blue-800 border-blue-200">
                    <Rocket class="h-4 w-4" />
                    <AlertTitle>Notification!</AlertTitle>
                    <AlertDescription>
                        {{ $page.props.flash.message }}
                    </AlertDescription>
                </Alert>
            </div>

            <!-- Filter/Search Section dan Tombol Create -->
            <!-- Menggabungkan search input dan create button dalam satu flex container -->
            <div class="flex flex-col md:flex-row items-center justify-between mb-4 gap-4">
                <!-- Search Input -->
                <div class="relative w-full md:max-w-sm">
                    <Input
                        v-model="search"
                        type="text"
                        placeholder="Search companies..."
                        class="pl-10 pr-8 w-full"
                    />
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                    <Button
                        v-if="search"
                        variant="ghost"
                        size="icon"
                        class="absolute right-1 top-1/2 -translate-y-1/2 h-7 w-7 text-gray-500 hover:bg-transparent"
                        @click="clearSearch"
                    >
                        <X class="h-4 w-4" />
                    </Button>
                </div>
                
                <!-- Tombol Create Company -->
                <Link :href="route('companies.create')">
                    <Button class="w-full md:w-auto">Create Company</Button>
                </Link>
            </div>

            <!-- Tabel Data Perusahaan -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <Table>
                    <TableCaption class="p-4 text-left text-gray-600">A list of your Companies.</TableCaption>
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
                        <TableRow v-for="company in props.companies" :key="company.id">
                            <TableCell class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ company.code }}
                            </TableCell>
                            <TableCell class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ company.name }}
                            </TableCell>
                            <TableCell class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{ company.note }}
                            </TableCell>
                            <TableCell class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <Link :href="route('companies.edit', { company: company.id })">
                                    <Button class="bg-slate-600 hover:bg-slate-700 text-white" variant="default" size="sm">
                                        Edit
                                    </Button>
                                </Link>
                                <Button 
                                    class="bg-red-600 hover:bg-red-700 text-white" 
                                    variant="default" 
                                    size="sm"
                                    @click="handleDelete(company.id)"
                                >
                                    Delete
                                </Button>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="props.companies.length === 0">
                            <TableCell colspan="4" class="text-center py-8 text-gray-500">
                                No companies found.
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
