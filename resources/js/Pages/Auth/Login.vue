<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/outline';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { developerBrand } from '@/constants/developer';

defineOptions({ layout: GuestLayout });

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const passwordVisible = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <!-- Wrapper to center the form on the page -->
    <div class="flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-6 md:p-8 space-y-4 bg-gray-800/80 rounded-xl shadow-lg backdrop-blur-sm">
            <div class="flex justify-center">
                <Link href="/">
                    <ApplicationLogo class="w-20 h-20 fill-current text-gold-400" />
                </Link>
            </div>

            <h1 class="text-2xl font-bold text-center text-gold-400">Account Login</h1>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-500">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" class="text-white" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" class="text-white"/>
                    <div class="relative">
                        <TextInput
                            id="password"
                            :type="passwordVisible ? 'text' : 'password'"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
                        <button type="button" @click="passwordVisible = !passwordVisible" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gold-400">
                            <EyeSlashIcon v-if="passwordVisible" class="h-5 w-5" />
                            <EyeIcon v-else class="h-5 w-5" />
                        </button>
                    </div>
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-400">Remember me</span>
                    </label>

                    <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-400 hover:text-gold-400">
                        Forgot password?
                    </Link>
                </div>

                <div class="mt-6">
                    <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log In
                    </PrimaryButton>
                </div>

                <div class="mt-6 text-center">
                    <Link :href="route('register')" class="underline text-sm text-gray-400 hover:text-gold-400">
                        Don't have an account? Register
                    </Link>
                </div>

                <div class="mt-4 text-center border-t border-gray-700 pt-4">
                    <a :href="developerBrand.phoneHref" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gold-400 underline">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.09a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92Z"/>
                        </svg>
                        IT Support
                    </a>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
</style>
