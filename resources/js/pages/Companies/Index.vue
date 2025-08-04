<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';

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
                 class="alert">
                {{ $page.props.flash.message }}
            </div>
            <Link :href="route('companies.create')"> <Button>Create Company</Button> </Link>
        </div>
    </AppLayout>
</template>
