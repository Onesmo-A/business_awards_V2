<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';

const form = useForm({
    name: '',
    title: '',
    bio: '',
    image: null,
    is_active: false,
});

const submit = () => {
    form.post(route('admin.guest-of-honor.store'));
};
</script>

<template>
    <Head title="Add Guest of Honor" />
    <AdminLayout>
        <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded-lg border border-gray-700 shadow-lg">
            <h2 class="text-xl font-bold text-white mb-6">Add New Guest of Honor</h2>
            
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="name" value="Full Name" class="text-gray-300" />
                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="title" value="Title / Position" class="text-gray-300" />
                    <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" />
                    <InputError :message="form.errors.title" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="bio" value="Biography" class="text-gray-300" />
                    <textarea id="bio" v-model="form.bio" rows="4" class="mt-1 block w-full bg-gray-900 border-gray-700 text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    <InputError :message="form.errors.bio" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="image" value="Photo" class="text-gray-300" />
                    <input type="file" @input="form.image = $event.target.files[0]" class="mt-1 block w-full text-gray-300" />
                    <InputError :message="form.errors.image" class="mt-2" />
                </div>

                <div class="flex items-center">
                    <Checkbox id="is_active" v-model="form.is_active" :checked="form.is_active" />
                    <label for="is_active" class="ml-2 text-sm text-gray-300">Set as Active (Current Year Guest)</label>
                </div>

                <div class="flex justify-end gap-4">
                    <Link :href="route('admin.guest-of-honor.index')" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">Cancel</Link>
                    <button type="submit" class="btn-primary" :disabled="form.processing">Save Guest</button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>