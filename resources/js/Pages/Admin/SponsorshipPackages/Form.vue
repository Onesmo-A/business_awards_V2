<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    sponsorshipPackage: Object,
});

const form = useForm({
    _method: props.sponsorshipPackage ? 'PUT' : 'POST',
    name: props.sponsorshipPackage?.name || '',
    price: props.sponsorshipPackage?.price || 0,
    description: props.sponsorshipPackage?.description || '',
    benefits: props.sponsorshipPackage?.benefits?.join('\n') || '', // Join array to string for textarea
    display_order: props.sponsorshipPackage?.display_order || 0,
    is_active: props.sponsorshipPackage?.is_active ?? true,
});

const submit = () => {
    const url = props.sponsorshipPackage
        ? route('admin.sponsorship-packages.update', props.sponsorshipPackage.id)
        : route('admin.sponsorship-packages.store');

    // Convert benefits string back to array before sending
    const data = {
        ...form.data(),
        benefits: form.benefits.split('\n').filter(b => b.trim() !== ''),
    };

    form.transform(() => data).post(url);
};
</script>

<template>
    <Head :title="sponsorshipPackage ? 'Edit Package' : 'Create Package'" />

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl font-bold text-white mb-6">{{ sponsorshipPackage ? 'Edit Sponsorship Package' : 'Create New Package' }}</h1>
        <form @submit.prevent="submit" class="bg-gray-800/50 shadow-md rounded-lg p-6">
            <div class="space-y-6">
                <div>
                    <InputLabel for="name" value="Package Name (e.g., Platinum)" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="price" value="Price (TZS)" />
                    <TextInput id="price" type="number" min="0" class="mt-1 block w-full" v-model="form.price" required />
                    <InputError class="mt-2" :message="form.errors.price" />
                </div>
                <div>
                    <InputLabel for="description" value="Short Description" />
                    <Textarea id="description" v-model="form.description" rows="3" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div>
                    <InputLabel for="benefits" value="Benefits (Andika moja kwa kila mstari)" />
                    <Textarea id="benefits" v-model="form.benefits" rows="6" class="mt-1 block w-full" placeholder="Logo on website&#10;2 VIP Tickets&#10;Social media mention" />
                    <InputError class="mt-2" :message="form.errors.benefits" />
                </div>
                <div>
                    <InputLabel for="display_order" value="Display Order" />
                    <TextInput id="display_order" type="number" min="0" class="mt-1 block w-full" v-model="form.display_order" />
                    <InputError class="mt-2" :message="form.errors.display_order" />
                </div>
                <div class="flex items-center">
                    <input type="checkbox" v-model="form.is_active" id="is_active" class="rounded border-gray-700 bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                    <label for="is_active" class="ml-2 block text-sm text-gray-300">Active</label>
                </div>
            </div>
            <div class="flex items-center justify-end mt-6 gap-4 border-t border-gray-700 pt-4">
                <Link :href="route('admin.sponsorship-packages.index')" class="text-gray-400 hover:text-white">Cancel</Link>
                <PrimaryButton :disabled="form.processing">
                    {{ sponsorshipPackage ? 'Update Package' : 'Create Package' }}
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

