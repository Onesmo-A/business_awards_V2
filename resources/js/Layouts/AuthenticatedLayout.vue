<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { developerBrand } from '@/constants/developer';
import {
    HomeIcon,
    DocumentPlusIcon,
    ClockIcon,
    TicketIcon,
    Bars3Icon,
    ChatBubbleLeftIcon
} from '@heroicons/vue/24/outline';

const showingSidebar = ref(false);

const sidebarLinks = [
    { name: 'Dashboard', href: route('dashboard'), icon: HomeIcon, current: route().current('dashboard') },
    { name: 'Start Application', href: route('user.applications.selectCategory'), icon: DocumentPlusIcon, current: route().current('user.applications.selectCategory') || route().current('user.applications.create') },
    { name: 'Application Status', href: route('user.applications.index'), icon: ClockIcon, current: route().current('user.applications.index') || route().current('user.applications.show') },
    { name: 'Tickets', href: route('user.tickets.index'), icon: TicketIcon, current: route().current('user.tickets.*') },
    { name: 'IT Support', href: developerBrand.whatsappUrl, icon: ChatBubbleLeftIcon, current: false, external: true },
];
</script>

<template>
<div>
    <Head title="User Dashboard" />

    <div class="min-h-screen bg-gray-900 text-gray-300 flex">
        <aside class="hidden md:flex flex-col w-64 bg-gray-800/50 border-r border-gold-500/10 fixed inset-y-0 z-40">
            <div class="flex items-center justify-center h-16 border-b border-gold-500/10">
                <Link :href="route('dashboard')">
                    <ApplicationLogo class="block h-12 w-auto" />
                </Link>
            </div>
            <nav class="mt-6 flex-1 overflow-y-auto">
                <template v-for="link in sidebarLinks" :key="link.name">
                    <component
                        v-if="link.external"
                        is="a"
                        :href="link.href"
                        target="_blank"
                        class="flex items-center px-6 py-3 text-sm transition-colors duration-200 hover:bg-gray-700/50 hover:text-white"
                    >
                        <component :is="link.icon" class="h-5 w-5 mr-3" />
                        {{ link.name }}
                    </component>
                    <Link
                        v-else
                        :href="link.href"
                        class="flex items-center px-6 py-3 text-sm transition-colors duration-200"
                        :class="[link.current ? 'bg-gold-500/10 text-gold-300' : 'hover:bg-gray-700/50 hover:text-white']"
                    >
                        <component :is="link.icon" class="h-5 w-5 mr-3" />
                        {{ link.name }}
                    </Link>
                </template>
            </nav>

            <div class="p-4 border-t border-gold-500/10 text-center">
                <p class="text-xs text-gray-400 mb-2">
                    Designed & Developed by
                </p>
                <div class="flex justify-center gap-2 text-xs">
                    <a :href="developerBrand.websiteUrl" target="_blank" rel="noopener noreferrer" class="font-semibold text-gold-400 hover:underline">{{ developerBrand.name }}</a>
                    <span class="text-gray-600">|</span>
                    <a :href="developerBrand.whatsappUrl" target="_blank" rel="noopener noreferrer" class="font-semibold text-gold-400 hover:underline">{{ developerBrand.phoneDisplay }}</a>
                </div>
            </div>
        </aside>

        <transition name="slide">
            <aside v-if="showingSidebar" class="fixed inset-0 z-50 flex md:hidden">
                <div class="fixed inset-0 bg-black/50" @click="showingSidebar = false"></div>
                <div class="relative flex flex-col w-64 bg-gray-800 border-r border-gold-500/10">
                    <div class="flex items-center justify-center h-16 border-b border-gold-500/10">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo class="block h-12 w-auto" />
                        </Link>
                    </div>
                    <nav class="mt-6 flex-1 overflow-y-auto">
                        <template v-for="link in sidebarLinks" :key="link.name">
                            <component
                                v-if="link.external"
                                is="a"
                                :href="link.href"
                                target="_blank"
                                @click="showingSidebar = false"
                                class="flex items-center px-6 py-3 text-sm transition-colors duration-200 hover:bg-gray-700/50 hover:text-white"
                            >
                                <component :is="link.icon" class="h-5 w-5 mr-3" />
                                {{ link.name }}
                            </component>
                            <ResponsiveNavLink
                                v-else
                                :href="link.href"
                                :active="link.current"
                                @click="showingSidebar = false"
                            >
                                {{ link.name }}
                            </ResponsiveNavLink>
                        </template>
                    </nav>
                    <div class="p-4 border-t border-gold-500/10 text-center">
                        <p class="text-xs text-gray-400 mb-2">
                            Designed & Developed by
                        </p>
                        <div class="flex justify-center gap-2 text-xs">
                            <a :href="developerBrand.websiteUrl" target="_blank" rel="noopener noreferrer" class="font-semibold text-gold-400 hover:underline">{{ developerBrand.name }}</a>
                            <span class="text-gray-600">|</span>
                            <a :href="developerBrand.whatsappUrl" target="_blank" rel="noopener noreferrer" class="font-semibold text-gold-400 hover:underline">{{ developerBrand.phoneDisplay }}</a>
                        </div>
                    </div>
                </div>
            </aside>
        </transition>

        <div class="flex-1 flex flex-col min-h-screen md:ml-64">
            <header class="relative z-50 bg-gray-800/50 border-b border-gold-500/10 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center md:hidden">
                    <button @click="showingSidebar = !showingSidebar" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                        <Bars3Icon class="h-6 w-6" />
                    </button>
                </div>

                <div class="flex-1 flex justify-end items-center">
                    <Dropdown
                        v-if="$page.props.auth.user"
                        :key="$page.props.auth.user.id"
                        align="right"
                        width="48"
                    >
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-400 bg-gray-800 hover:text-gray-200 focus:outline-none transition z-50 relative"
                                >
                                    {{ $page.props.auth.user.name }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </template>
                        <template #content>
                            <ResponsiveNavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Logout
                            </ResponsiveNavLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 w-full max-w-full">
                <slot />
            </main>

            <footer class="md:hidden py-6 px-4 text-center border-t border-gold-500/10 bg-gray-800/70">
                <p class="text-sm text-gray-300 font-medium mb-3">
                    Designed & Developed by
                    <a :href="developerBrand.websiteUrl" target="_blank" rel="noopener noreferrer" class="font-semibold text-gold-400 hover:underline">
                        {{ developerBrand.name }}
                    </a>
                </p>
                <div class="flex justify-center gap-4 text-xs">
                    <a :href="developerBrand.websiteUrl" target="_blank" rel="noopener noreferrer" class="text-gold-400 hover:text-gold-300 hover:underline">
                        {{ developerBrand.name }}
                    </a>
                    <span class="text-gray-600">|</span>
                    <a :href="developerBrand.whatsappUrl" target="_blank" rel="noopener noreferrer" class="text-gold-400 hover:text-gold-300 hover:underline">
                        {{ developerBrand.phoneDisplay }}
                    </a>
                </div>
            </footer>
        </div>
    </div>
</div>
</template>

<style>
.slide-enter-active, .slide-leave-active {
    transition: transform 0.3s ease;
}
.slide-enter-from {
    transform: translateX(-100%);
}
.slide-enter-to {
    transform: translateX(0);
}
.slide-leave-from {
    transform: translateX(0);
}
.slide-leave-to {
    transform: translateX(-100%);
}
</style>
