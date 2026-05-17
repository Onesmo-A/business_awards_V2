<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { defineProps, ref, onMounted } from 'vue';

const props = defineProps({
    categories: Array,
    currentYear: Number,
    prefill: Object,
});

const form = useForm({
    name: props.prefill?.name || '',
    category_id: props.prefill?.category_id || '',
    year: props.currentYear, // BORESHO: Weka mwaka
    bio: props.prefill?.bio || '',
    image: null,
    image_path: props.prefill?.image_path || null, // Hifadhi path ya picha iliyopo
    facebook_url: props.prefill?.facebook_url || '',
    instagram_url: props.prefill?.instagram_url || '',
    tiktok_url: props.prefill?.tiktok_url || '',
    source_application_id: props.prefill?.source_application_id || null,
});

const submit = () => {
    form.post(route('admin.nominees.store'), {
        onFinish: () => form.reset(),
    });
};

const photoPreview = ref(null);

// Ikiwa kuna picha kutoka kwenye application, ionyeshe
onMounted(() => {
    if (props.prefill?.image_path) {
        photoPreview.value = `/file/storage/${props.prefill.image_path}`;
    }
});

const onFileChange = (event) => {
    const file = event.target.files[0];
    form.image = file;
    if (file) {
        photoPreview.value = URL.createObjectURL(file);
    }
};
</script>

<template>
    <Head title="Create Nominee" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Add New Nominee</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <form @submit.prevent="submit" class="max-w-2xl mx-auto mt-8">
                            <!-- BORESHO: Onyesha mwaka -->
                            <div class="mb-6 p-4 bg-blue-100 dark:bg-blue-900/30 border border-blue-300 dark:border-blue-700 rounded-lg flex items-center justify-center">
                                <p class="text-blue-800 dark:text-blue-200 font-medium">
                                    Adding nominee for Season: <span class="font-bold text-lg">{{ form.year }}</span>
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="name" value="Nominee Name / Brand" />
                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div>
                                    <InputLabel for="category_id" value="Category" />
                                    <select id="category_id" v-model="form.category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="" disabled>Select a category</option>
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
                                <InputLabel for="image" value="Nominee Image" />
                                <input id="image" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300" @change="onFileChange" />
                                
                                <!-- BORESHO: Onyesha preview ya picha -->
                                <div v-if="photoPreview" class="mt-4">
                                    <p class="text-sm text-gray-500 mb-2">Image Preview:</p>
                                    <img :src="photoPreview" alt="Nominee Preview" class="h-32 w-32 object-cover rounded-lg border border-gray-300 dark:border-gray-600" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.image" />
                            </div>

                            <div class="mt-6 border-t border-gray-700 pt-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Social Media Links</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <InputLabel for="instagram_url" value="Instagram URL" />
                                        <TextInput id="instagram_url" type="url" class="mt-1 block w-full" v-model="form.instagram_url" placeholder="https://instagram.com/..." />
                                        <InputError class="mt-2" :message="form.errors.instagram_url" />
                                    </div>
                                    <div>
                                        <InputLabel for="facebook_url" value="Facebook URL" />
                                        <TextInput id="facebook_url" type="url" class="mt-1 block w-full" v-model="form.facebook_url" placeholder="https://facebook.com/..." />
                                        <InputError class="mt-2" :message="form.errors.facebook_url" />
                                    </div>
                                    <div>
                                        <InputLabel for="tiktok_url" value="TikTok URL" />
                                        <TextInput id="tiktok_url" type="url" class="mt-1 block w-full" v-model="form.tiktok_url" placeholder="https://tiktok.com/@..." />
                                        <InputError class="mt-2" :message="form.errors.tiktok_url" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-8">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create Nominee
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>