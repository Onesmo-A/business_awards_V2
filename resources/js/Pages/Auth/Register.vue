<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputError from '@/Components/InputError.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { developerBrand } from '@/constants/developer';

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <!-- Center Wrapper -->
        <div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md p-6 md:p-8 space-y-4 bg-gray-800/80 rounded-xl shadow-lg backdrop-blur-sm">

                <!-- Logo -->
                <div class="flex justify-center">
                    <Link href="/">
                        <ApplicationLogo class="w-20 h-20 fill-current text-gold-400" />
                    </Link>
                </div>

                <h1 class="text-2xl font-bold text-center text-gold-400">
                    Create Account
                </h1>

                <form @submit.prevent="submit">

                    <!-- Name -->
                    <div>
                        <InputLabel for="name" value="Full Name" class="text-white" />
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

                    <!-- Email -->
                    <div class="mt-4">
                        <InputLabel for="email" value="Email Address" class="text-white" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Phone -->
                    <div class="mt-4">
                        <InputLabel for="phone_number" value="Phone Number" class="text-white" />
                        <TextInput
                            id="phone_number"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.phone_number"
                            required
                            autocomplete="tel"
                        />
                        <InputError class="mt-2" :message="form.errors.phone_number" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <InputLabel for="password" value="Password" class="text-white" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirm Password" class="text-white" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <!-- Button -->
                    <div class="mt-6">
                        <PrimaryButton 
                            class="w-full justify-center"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Register Account
                        </PrimaryButton>
                    </div>

                    <!-- Footer Links -->
                    <div class="mt-6 text-center">
                        <Link
                            :href="route('login')"
                            class="underline text-sm text-gray-400 hover:text-gold-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Already have an account? Log in
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
    </GuestLayout>
</template>
