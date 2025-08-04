<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea'; // Import Textarea
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Companies',
        href: route('companies.index'),
    },
    {
        title: 'Create a Company',
        href: route('companies.create'),
    },
];

const form = useForm({
    code: '',
    name: '',
    note: '',
});

const handleSubmit = () => {
    form.post(route('companies.store'));
};


// Fungsi untuk membatalkan dan kembali ke halaman index
const handleCancel = () => {
    window.history.back(); // Kembali ke halaman sebelumnya
};
</script>

<template>
    <Head title="Create a Company" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Mengurangi padding pada kontainer utama secara keseluruhan -->
        <div class="p-4 md:p-6 lg:p-8">
            <!-- Kontainer untuk membungkus form, dengan lebar maksimum yang disesuaikan. mx-auto telah dihapus. -->
            <div class="max-w-3xl">
                <!-- Mengurangi margin-bottom pada judul untuk mendekatkan ke form -->
                <h1 class="text-2xl font-semibold mb-4 text-gray-800">Create New Company</h1>
                
                <form @submit.prevent="handleSubmit" class="space-y-4"> <!-- Mengurangi space-y -->
                    <!-- Grid untuk Code dan Name -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4"> <!-- Mengurangi gap -->
                        <!-- Company Code -->
                        <div>
                            <Label for="code">Code</Label>
                            <Input
                                id="code"
                                v-model="form.code"
                                type="text"
                                placeholder="Please enter a code"
                                class="mt-1 w-full"
                            />
                            <div v-if="form.errors.code" class="text-sm text-red-600 mt-1">{{ form.errors.code }}</div>
                        </div>

                        <!-- Company Name -->
                        <div>
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                placeholder="Please enter a name"
                                class="mt-1 w-full"
                            />
                            <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</div>
                        </div>
                    </div>

                    <!-- Note -->
                    <div>
                        <Label for="note">Note</Label>
                        <Textarea
                            id="note"
                            v-model="form.note"
                            placeholder="Optional note"
                            class="mt-1 w-full"
                            rows="4"
                        />
                        <div v-if="form.errors.note" class="text-sm text-red-600 mt-1">{{ form.errors.note }}</div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center gap-3 pt-4">
                        <Button type="submit" :disabled="form.processing">
                            <span v-if="form.processing">Creating...</span>
                            <span v-else>Create</span>
                        </Button>
                        <Button 
                            type="button" 
                            variant="outline" 
                            @click="handleCancel" 
                            :disabled="form.processing"
                        >
                            Cancel
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
