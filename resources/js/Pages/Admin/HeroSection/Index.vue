<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    slides: Array,
});

const showModal = ref(false);
const editingSlide = ref(null);

const form = useForm({
    title: '',
    description: '',
    image: null,
    display_order: 0,
    is_active: true,
    buttons: [],
});

const openCreateModal = () => {
    editingSlide.value = null;
    form.reset();
    showModal.value = true;
};

const openEditModal = (slide) => {
    editingSlide.value = slide;
    form.title = slide.title;
    form.description = slide.description;
    form.image = null;
    form.display_order = slide.display_order;
    form.is_active = slide.is_active;
    form.buttons = slide.buttons ? JSON.parse(JSON.stringify(slide.buttons)) : [];
    showModal.value = true;
};

const addButton = () => {
    form.buttons.push({ text: '', link: '/', primary: true });
};

const removeButton = (index) => {
    form.buttons.splice(index, 1);
};

const onFileChange = (event) => {
    form.image = event.target.files[0];
};

const submit = () => {
    const url = editingSlide.value
        ? route('admin.hero-sections.update', editingSlide.value.id)
        : route('admin.hero-sections.store');

    form.transform(data => ({
        ...data,
        _method: editingSlide.value ? 'PUT' : 'POST',
    })).post(url, {
        onSuccess: () => showModal.value = false,
        forceFormData: true,
    });
};

const deleteSlide = (id) => {
    if (confirm('Are you sure you want to delete this slide?')) {
        router.delete(route('admin.hero-sections.destroy', id));
    }
};
</script>

<template>
    <AdminLayout title="Manage Hero Section">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Manage Hero Section</h1>
            <PrimaryButton @click="openCreateModal">Add New Slide</PrimaryButton>
        </div>

        <div class="bg-gray-800/50 border border-gold-500/10 shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <tr v-for="slide in slides" :key="slide.id">
                        <td class="px-6 py-4">{{ slide.display_order }}</td>
                        <td class="px-6 py-4">
                            <img :src="slide.image_url" class="h-10 w-20 object-cover rounded">
                        </td>
                        <td class="px-6 py-4">{{ slide.title }}</td>
                        <td class="px-6 py-4">
                            <span :class="slide.is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'" class="px-2 py-1 text-xs font-semibold rounded-full">
                                {{ slide.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="openEditModal(slide)" class="text-indigo-400 hover:text-indigo-300 mr-3">Edit</button>
                            <button @click="deleteSlide(slide.id)" class="text-red-500 hover:text-red-400">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Modal :show="showModal" @close="showModal = false">
            <div class="p-6 bg-gray-800 text-white">
                <h2 class="text-lg font-medium mb-4">{{ editingSlide ? 'Edit Slide' : 'Create Slide' }}</h2>

                <div class="space-y-4">
                    <div>
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <InputLabel for="description" value="Description" />
                        <textarea id="description" v-model="form.description" class="input-field w-full"></textarea>
                    </div>
                    <div>
                        <InputLabel for="image" value="Image" />
                        <input type="file" @change="onFileChange" class="input-field-file" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="display_order" value="Display Order" />
                            <TextInput id="display_order" v-model="form.display_order" type="number" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <InputLabel for="is_active" value="Status" />
                            <select v-model="form.is_active" class="input-field w-full mt-1">
                                <option :value="true">Active</option>
                                <option :value="false">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-md font-medium">Buttons</h3>
                            <SecondaryButton @click="addButton">Add Button</SecondaryButton>
                        </div>
                        <div v-for="(button, index) in form.buttons" :key="index" class="p-3 border border-gray-700 rounded-lg mb-3 space-y-2 relative">
                            <DangerButton @click="removeButton(index)" class="absolute -top-2 -right-2 !p-1 h-6 w-6 flex items-center justify-center rounded-full">X</DangerButton>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <InputLabel :for="`btn_text_${index}`" value="Button Text" />
                                    <TextInput :id="`btn_text_${index}`" v-model="button.text" type="text" class="mt-1 block w-full" />
                                </div>
                                <div>
                                    <InputLabel :for="`btn_link_${index}`" value="Button Link" />
                                    <TextInput :id="`btn_link_${index}`" v-model="button.link" type="text" class="mt-1 block w-full" />
                                </div>
                            </div>
                             <div>
                                <InputLabel :for="`btn_type_${index}`" value="Button Type" />
                                <select v-model="button.primary" class="input-field w-full mt-1">
                                    <option :value="true">Primary</option>
                                    <option :value="false">Secondary</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="showModal = false">Cancel</SecondaryButton>
                    <PrimaryButton @click="submit" class="ml-3" :disabled="form.processing">Save</PrimaryButton>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>

<style scoped>
.input-field {
    @apply mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500;
}
.input-field-file {
    @apply mt-1 block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/10 file:text-indigo-300 hover:file:bg-indigo-500/20;
}
</style>