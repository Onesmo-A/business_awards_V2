<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    parentCategories: Array,
    currentYear: Number,
});

const form = useForm({
    name: '',
    description: '',
    year: props.currentYear, // BORESHO: Ongeza mwaka kwenye fomu
    image: null,
    parent_id: '', 
    status: 'active',
    nomination_fee: 0, // Ongeza nomination_fee
    is_free: false, // BORESHO: Ongeza field ya is_free
});

const submit = () => {
    form.post(route('admin.categories.store'), {
        onFinish: () => form.reset(), // Boresha reset iwe rahisi
    });
};

const onFileChange = (event) => {
    form.image = event.target.files[0];
};
</script>

<template>
    <Head title="Create Category" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Category</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
                            <!-- BORESHO: Onyesha mwaka wa msimu unaotengenezewa kategoria -->
                            <div class="mb-4 p-3 bg-blue-100 dark:bg-blue-900/50 border border-blue-300 dark:border-blue-700 rounded-lg text-center">
                                <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                    You are creating a category for the
                                    <span class="font-bold">{{ form.year }}</span>
                                    season.
                                </p>
                            </div>

                            <div>
                                <InputLabel for="name" value="Category Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="parent_id" value="Parent Category (Optional)" />
                                <select
                                    id="parent_id"
                                    v-model="form.parent_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                >
                                    <option value="">-- No Parent (It's a Main Category) --</option>
                                    <option v-for="parent in parentCategories" :key="parent.id" :value="parent.id">
                                        {{ parent.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.parent_id" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="description" value="Description" />
                                <textarea
                                    id="description"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    v-model="form.description"
                                    autocomplete="description"
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <!-- BORESHO: Ongeza checkbox ya 'is_free' (itaonekana tu kwa sub-categories) -->
                            <div v-if="form.parent_id" class="mt-4">
                                <label class="flex items-center">
                                    <input type="checkbox" v-model="form.is_free" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">This is a FREE category (no nomination fee)</span>
                                </label>
                                <InputError class="mt-2" :message="form.errors.is_free" />
                            </div>


                            <!-- Nomination Fee (Only for sub-categories) -->
                            <!-- BORESHO: Ficha ada kama kategoria ni ya bure -->
                            <div v-if="form.parent_id && !form.is_free">
                                <div class="mt-4">
                                    <InputLabel for="nomination_fee" value="Nomination Fee (TZS)" />
                                    <TextInput
                                        id="nomination_fee"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.nomination_fee"
                                        required
                                        min="0"
                                        step="1000"
                                        autocomplete="off"
                                    />
                                    <InputError class="mt-2" :message="form.errors.nomination_fee" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="image" value="Category Image" />
                                <input
                                    id="image"
                                    type="file"
                                    class="mt-1 block w-full"
                                    @change="onFileChange"
                                />
                                <InputError class="mt-2" :message="form.errors.image" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="status" value="Status" />
                                <select
                                    id="status"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    v-model="form.status"
                                    required
                                >
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.status" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create Category
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>