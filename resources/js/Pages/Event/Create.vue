<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    title: String,
    selectedCategory: Object,
    nomination_fee: Number,
});

const form = useForm({
    category_id: props.selectedCategory.id,
    applicant_name: '',
    applicant_phone: '',
    applicant_email: '',
    bio: '',
    photo: null,
});

const submit = () => {
    form.post(route('user.applications.store'));
};
</script>

<template>
    <Head :title="title" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
                {{ title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-[#121212] border border-[#333] overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <div class="mb-8 border-b border-[#333] pb-6">
                            <h3 class="text-lg font-medium text-[var(--accent-primary)]">Taarifa za Mwombaji</h3>
                            <p class="mt-1 text-sm text-gray-400">
                                Unajaza fomu kwa ajili ya kategoria ya <span class="text-white font-bold">{{ selectedCategory.name }}</span>.
                                Ada ya maombi ni <span class="text-[var(--accent-primary)] font-bold">TZS {{ nomination_fee.toLocaleString() }}</span>.
                            </p>
                        </div>

                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Name -->
                            <div>
                                <InputLabel for="applicant_name" value="Jina Kamili (au Jina la Biashara)" class="text-gray-300" />
                                <TextInput
                                    id="applicant_name"
                                    type="text"
                                    class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                    v-model="form.applicant_name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.applicant_name" />
                            </div>

                            <!-- Phone & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="applicant_phone" value="Namba ya Simu (kwa Malipo)" class="text-gray-300" />
                                    <TextInput
                                        id="applicant_phone"
                                        type="text"
                                        class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                        v-model="form.applicant_phone"
                                        required
                                        placeholder="Mfano: 0712345678"
                                    />
                                    <InputError class="mt-2" :message="form.errors.applicant_phone" />
                                </div>

                                <div>
                                    <InputLabel for="applicant_email" value="Barua Pepe" class="text-gray-300" />
                                    <TextInput
                                        id="applicant_email"
                                        type="email"
                                        class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                        v-model="form.applicant_email"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.applicant_email" />
                                </div>
                            </div>

                            <!-- Bio -->
                            <div>
                                <InputLabel for="bio" value="Wasifu Fupi (Bio)" class="text-gray-300" />
                                <textarea
                                    id="bio"
                                    class="mt-1 block w-full rounded-md shadow-sm bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                    v-model="form.bio"
                                    rows="4"
                                    required
                                    placeholder="Elezea kwa ufupi kuhusu mafanikio yako au biashara yako..."
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.bio" />
                            </div>

                            <!-- Photo -->
                            <div>
                                <InputLabel for="photo" value="Picha ya Mwombaji/Nembo" class="text-gray-300" />
                                <input
                                    type="file"
                                    id="photo"
                                    @input="form.photo = $event.target.files[0]"
                                    class="mt-1 block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#333] file:text-[var(--accent-primary)] hover:file:bg-[#444]"
                                />
                                <InputError class="mt-2" :message="form.errors.photo" />
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB.</p>
                            </div>

                            <div class="flex items-center justify-end mt-8 pt-6 border-t border-[#333]">
                                <Link :href="route('user.applications.selectCategory')" class="text-sm text-gray-400 hover:text-white mr-4">
                                    Ghairi
                                </Link>
                                <PrimaryButton class="btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Tuma Maombi & Lipa
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>