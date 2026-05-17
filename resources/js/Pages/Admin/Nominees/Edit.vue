<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    nominee: Object,
    categories: Array,
});

const form = useForm({
    _method: 'put',
    name: props.nominee.name,
    category_id: props.nominee.category_id,
    year: props.nominee.year, // BORESHO: Weka mwaka
    bio: props.nominee.bio,
    image: null,
    facebook_url: props.nominee.facebook_url,
    instagram_url: props.nominee.instagram_url,
    tiktok_url: props.nominee.tiktok_url,
});

const submit = () => {
    form.post(route('admin.nominees.update', props.nominee.id));
};

const onFileChange = (event) => {
    form.image = event.target.files[0];
};
</script>

<template>
    <Head title="Edit Nominee" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Nominee</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <form @submit.prevent="submit" class="max-w-2xl mx-auto mt-8">
                            
                            <!-- BORESHO: Onyesha mwaka (Disabled) -->
                            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="year" value="Season Year" />
                                    <TextInput id="year" type="number" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 cursor-not-allowed" v-model="form.year" disabled />
                                    <p class="text-xs text-gray-500 mt-1">Year cannot be changed.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="name" value="Nominee Name / Brand" />
                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div>
                                    <InputLabel for="category_id" value="Category" />
                                    <select id="category_id" v-model="form.category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.category_id" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="bio" value="Biography / Description" />
                                <textarea id="bio" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" v-model="form.bio" rows="4"></textarea>
                                <InputError class="mt-2" :message="form.errors.bio" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="image" value="Nominee Image (Leave blank to keep current)" />
                                <input id="image" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300" @change="onFileChange" />
                                <InputError class="mt-2" :message="form.errors.image" />
                                
                                <div v-if="nominee.image_url" class="mt-4">
                                    <p class="text-sm text-gray-500 mb-2">Current Image:</p>
                                    <img :src="nominee.image_url" alt="Current Image" class="h-24 w-24 object-cover rounded-lg border border-gray-600">
                                </div>
                            </div>

                            <div class="mt-6 border-t border-gray-700 pt-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Social Media Links</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <InputLabel for="instagram_url" value="Instagram URL" />
                                        <TextInput id="instagram_url" type="url" class="mt-1 block w-full" v-model="form.instagram_url" />
                                        <InputError class="mt-2" :message="form.errors.instagram_url" />
                                    </div>
                                    <div>
                                        <InputLabel for="facebook_url" value="Facebook URL" />
                                        <TextInput id="facebook_url" type="url" class="mt-1 block w-full" v-model="form.facebook_url" />
                                        <InputError class="mt-2" :message="form.errors.facebook_url" />
                                    </div>
                                    <div>
                                        <InputLabel for="tiktok_url" value="TikTok URL" />
                                        <TextInput id="tiktok_url" type="url" class="mt-1 block w-full" v-model="form.tiktok_url" />
                                        <InputError class="mt-2" :message="form.errors.tiktok_url" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-8">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update Nominee
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>