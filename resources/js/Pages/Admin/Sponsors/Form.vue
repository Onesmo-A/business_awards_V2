<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

const props = defineProps({
    sponsor: Object,
});

const form = useForm({
    _method: props.sponsor ? 'PUT' : 'POST',
    name: props.sponsor?.name || '',
    website_url: props.sponsor?.website_url || '',
    tier: props.sponsor?.tier || 'partner',
    is_active: props.sponsor?.is_active ?? true,
    display_order: props.sponsor?.display_order || 0,
    logo: null,
});

const logoPreview = ref(props.sponsor?.logo_url || null);

const onFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.logo = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            logoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    const url = props.sponsor
        ? route('admin.sponsors.update', props.sponsor.id)
        : route('admin.sponsors.store');

    form.post(url, {
        preserveScroll: true,
    });
};

const tiers = ['main', 'platinum', 'gold', 'silver', 'bronze', 'partner'];
</script>

<template>
    <Head :title="sponsor ? 'Edit Sponsor' : 'Create Sponsor'" />

    <AdminLayout>
        <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-6">{{ sponsor ? 'Edit Sponsor' : 'Create New Sponsor' }}</h1>
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <InputLabel for="name" value="Sponsor Name" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Website URL -->
                            <div>
                                <InputLabel for="website_url" value="Website URL" />
                                <TextInput id="website_url" type="url" class="mt-1 block w-full" v-model="form.website_url" placeholder="https://example.com" />
                                <InputError class="mt-2" :message="form.errors.website_url" />
                            </div>

                            <!-- Tier -->
                            <div>
                                <InputLabel for="tier" value="Tier" />
                                <select id="tier" v-model="form.tier" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option v-for="tierOption in tiers" :key="tierOption" :value="tierOption" class="capitalize">
                                        {{ tierOption }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.tier" />
                            </div>

                            <!-- Display Order -->
                            <div>
                                <InputLabel for="display_order" value="Display Order" />
                                <TextInput id="display_order" type="number" min="0" class="mt-1 block w-full" v-model="form.display_order" />
                                <InputError class="mt-2" :message="form.errors.display_order" />
                            </div>

                            <!-- Logo -->
                            <div class="md:col-span-2">
                                <InputLabel for="logo" value="Sponsor Logo" />
                                <input id="logo" type="file" @input="onFileChange" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <InputError class="mt-2" :message="form.errors.logo" />
                                <div v-if="logoPreview" class="mt-4 p-4 border rounded-md inline-block">
                                    <img :src="logoPreview" alt="Logo Preview" class="h-24 w-auto object-contain">
                                </div>
                            </div>

                            <!-- Is Active -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                    <span class="ml-2 text-sm text-gray-600">Active (Visible on public site)</span>
                                </label>
                                <InputError class="mt-2" :message="form.errors.is_active" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <Link :href="route('admin.sponsors.index')" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </Link>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ sponsor ? 'Update Sponsor' : 'Create Sponsor' }}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>