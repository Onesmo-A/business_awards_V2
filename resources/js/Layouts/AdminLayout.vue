<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {
    HomeIcon,
    UsersIcon,
    Cog6ToothIcon,
    TicketIcon,
    TrophyIcon,
    PhotoIcon,
    NewspaperIcon,
    VideoCameraIcon,
    MapPinIcon,
    UserGroupIcon,
    PresentationChartLineIcon,
    QueueListIcon,
    BanknotesIcon,
    ChatBubbleLeftRightIcon,
    EnvelopeIcon,
    UserPlusIcon,
    StarIcon,
    ViewfinderCircleIcon,
    CircleStackIcon,
    ExclamationTriangleIcon,
} from '@heroicons/vue/24/outline';

const showingNavigationDropdown = ref(false);

const sidebarLinks = [
    { name: 'Dashboard', href: 'admin.dashboard', icon: HomeIcon, current: route().current('admin.dashboard') },
    {
        name: 'Content', isHeader: true
    },
    { name: 'Hero Section', href: 'admin.hero-sections.index', icon: PresentationChartLineIcon, current: route().current('admin.hero-sections.*') },
    { name: 'Posts', href: 'admin.posts.index', icon: NewspaperIcon, current: route().current('admin.posts.*') },
    { name: 'Gallery Albums', href: 'admin.gallery-albums.index', icon: PhotoIcon, current: route().current('admin.gallery-albums.*') },
    { name: 'Reels', href: 'admin.reels.index', icon: VideoCameraIcon, current: route().current('admin.reels.*') },
    { name: 'Sponsorship Packages', href: 'admin.sponsorship-packages.index', icon: TrophyIcon, current: route().current('admin.sponsorship-packages.*') },
    { name: 'Sponsors', href: 'admin.sponsors.index', icon: BanknotesIcon, current: route().current('admin.sponsors.*') },
    { name: 'Event Location', href: 'admin.map-sections.index', icon: MapPinIcon, current: route().current('admin.map-sections.*') },
    { name: 'Guest of Honor', href: 'admin.guest-of-honor.index', icon: StarIcon, current: route().current('admin.guest-of-honor.*') },
    {
        name: 'User Activity', isHeader: true
    },
    { name: 'Users', href: 'admin.users.index', icon: UsersIcon, current: route().current('admin.users.*') },
    { name: 'Suggestions', href: 'admin.suggestions.index', icon: ChatBubbleLeftRightIcon, current: route().current('admin.suggestions.*') },
    { name: 'Applications', href: 'admin.applications.index', icon: UserPlusIcon, current: route().current('admin.applications.*') },
    { name: 'Transactions', href: 'admin.transactions.index', icon: BanknotesIcon, current: route().current('admin.transactions.*') },
    { name: 'Invitations', href: 'admin.invitations.index', icon: EnvelopeIcon, current: route().current('admin.invitations.*') },
    {
        name: 'Marathon', isHeader: true
    },
    { name: 'Registrations', href: 'admin.marathon.index', icon: QueueListIcon, current: route().current('admin.marathon.*') },
    {
        name: 'Tickets', isHeader: true
    },
    { name: 'Dashboard', href: 'admin.tickets.dashboard', icon: TicketIcon, current: route().current('admin.tickets.dashboard') },
    { name: 'Ticket Types', href: 'admin.ticket-types.index', icon: Cog6ToothIcon, current: route().current('admin.ticket-types.*') },
    { name: 'Scan Ticket', href: 'admin.tickets.scan', icon: ViewfinderCircleIcon, current: route().current('admin.tickets.scan') },
    {
        name: 'Voting', isHeader: true
    },
    { name: 'Categories', href: 'admin.categories.index', icon: TrophyIcon, current: route().current('admin.categories.*') },
    { name: 'Nominees', href: 'admin.nominees.index', icon: UserGroupIcon, current: route().current('admin.nominees.*') },
    { name: 'Votes', href: 'admin.votes.index', icon: QueueListIcon, current: route().current('admin.votes.index') || route().current('admin.votes.export.*') || route().current('admin.votes.download.*') },
    { name: 'Vote Attempt Logs', href: 'admin.votes.attempt-logs.index', icon: ExclamationTriangleIcon, current: route().current('admin.votes.attempt-logs.*') },
    { name: 'Vote Archives', href: 'admin.votes.archive.index', icon: CircleStackIcon, current: route().current('admin.votes.archive.*') },
    { name: 'Winners', href: 'admin.winners.index', icon: TrophyIcon, current: route().current('admin.winners.*') },
    {
        name: 'Award Seasons', isHeader: true
    },
    { name: 'Seasons', href: 'admin.seasons.index', icon: TrophyIcon, current: route().current('admin.seasons.*') },
    {
        name: 'Settings', isHeader: true
    },
    { name: 'General Settings', href: 'admin.settings.index', icon: Cog6ToothIcon, current: route().current('admin.settings.index') },
];

</script>

<template>
    <div class="min-h-screen bg-gray-900 text-gray-300 flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800/50 border-r border-gold-500/10 flex-shrink-0 hidden md:block">
            <div class="py-4 px-6">
                <Link :href="route('admin.dashboard')">
                    <ApplicationLogo class="block h-12 w-auto" />
                </Link>
            </div>
            <nav class="mt-6">
                <template v-for="link in sidebarLinks" :key="link.name">
                    <div v-if="link.isHeader" class="px-6 py-2 text-xs font-semibold text-gray-400 uppercase">
                        {{ link.name }}
                    </div>
                    <Link v-else :href="route(link.href)"
                          class="flex items-center px-6 py-2 text-sm transition-colors duration-200"
                          :class="[link.current ? 'bg-gold-500/10 text-gold-300' : 'hover:bg-gray-700/50 hover:text-white']">
                        <component :is="link.icon" class="h-5 w-5 mr-3" />
                        {{ link.name }}
                    </Link>
                </template>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-gray-800/50 border-b border-gold-500/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Hamburger for mobile -->
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="hidden md:flex md:items-center md:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-400 bg-gray-800 hover:text-gray-200 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="md:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <template v-for="link in sidebarLinks" :key="link.name">
                             <div v-if="link.isHeader" class="px-4 pt-2 pb-1 text-xs font-semibold text-gray-400 uppercase">
                                {{ link.name }}
                            </div>
                            <ResponsiveNavLink v-else :href="route(link.href)" :active="link.current">
                                {{ link.name }}
                            </ResponsiveNavLink>
                        </template>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
