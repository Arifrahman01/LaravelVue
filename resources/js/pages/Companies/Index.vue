<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Rocket } from 'lucide-vue-next';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table"

interface companies {
    id: number;
    code: string;
    name: string;
    note: string;
}

interface Props {
    companies: companies[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Company',
        href: '/companies',
    },
];
const page = usePage();


</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div v-if="page.props.flash?.message"
                 class="mb-4">
                <Alert class="bg-blue-50 text-blue-800">
                    <Rocket class="h-4 w-4" />
                    <AlertTitle>Notification!</AlertTitle>
                    <AlertDescription>
                        {{ $page.props.flash.message }}
                    </AlertDescription>
                </Alert>
            </div>
            <div>
                <Link :href="route('companies.create')"> <Button>Create Company</Button> </Link>
            </div>
            <div>
                <Table>
                    <TableCaption>A list of your Company.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">
                                Code
                            </TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Note</TableHead>
                            <TableHead class="text-center">
                                Action
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="companies in props.companies"
                                  :key="companies.id">
                            <TableCell class="font-medium">
                                {{ companies.code }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ companies.name }}
                            </TableCell>
                            <TableCell>
                                {{ companies.note }}
                            </TableCell>
                            <TableCell class="text-right">
                                <Link :href="route('companies.edit', { id: companies.id })">
                                <Button class="bg-slate-600"
                                        variant="outline"
                                        size="sm">
                                    Edit
                                </Button>
                                </Link>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

        </div>
    </AppLayout>
</template>
