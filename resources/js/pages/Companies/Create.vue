<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head , useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create a Company',
        href: '/companies/create',
    },
];
const form = useForm({
    code: '',
    name: '',
    note: '',
 });

 const handleSubmit = () => {
    form.post(route('companies.store'))
 }

</script>

<template>

    <Head title="Create a Company" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4 ">
                <div class="space-y-2">
                    <Label for="Company Code">Code</Label>
                    <Input v-model="form.code" type="text" placeholder="Enter Company Code" />
                    <div v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</div>
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
                <Button type="submit">Create</Button>
            </form>
        </div>
    </AppLayout>
</template>
