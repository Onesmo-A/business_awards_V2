<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    ArrowRightIcon,
    ChartBarIcon,
    CheckBadgeIcon,
    ClipboardDocumentCheckIcon,
    ClockIcon,
    SparklesIcon,
    TicketIcon,
    TrophyIcon,
    UserIcon,
} from '@heroicons/vue/24/outline';

const user = usePage().props.auth.user;

const props = defineProps({
    stats: Object,
    pendingApplication: Object,
    winningApplications: Array,
});

const firstWinningApplication = computed(() => props.winningApplications?.[0] || null);
const hasWinningApplications = computed(() => (props.winningApplications?.length || 0) > 0);

const actionCards = [
    {
        title: 'Start Application',
        description: 'Submit your nomination for the current awards season.',
        href: route('user.applications.selectCategory'),
        action: 'Apply Now',
        icon: TrophyIcon,
        tone: 'gold',
    },
    {
        title: 'Your Applications',
        description: 'Track review progress, payments, and approval updates.',
        href: route('user.applications.index'),
        action: 'View Status',
        icon: ClipboardDocumentCheckIcon,
        tone: 'blue',
    },
    {
        title: 'Your Profile',
        description: 'Keep your account details polished and up to date.',
        href: route('profile.edit'),
        action: 'Edit Profile',
        icon: UserIcon,
        tone: 'emerald',
    },
];

const statCards = [
    {
        label: 'Total Applications',
        value: props.stats.totalApplications,
        href: route('user.applications.index'),
        icon: ChartBarIcon,
        accent: 'text-[#D4AF37]',
        border: 'hover:border-[#D4AF37]/70',
        note: 'All submissions',
    },
    {
        label: 'Pending',
        value: props.stats.pendingApplications,
        href: route('user.applications.index', { status: 'pending' }),
        icon: ClockIcon,
        accent: 'text-amber-300',
        border: 'hover:border-amber-300/70',
        note: 'Needs attention',
    },
    {
        label: 'Approved',
        value: props.stats.approvedApplications,
        href: route('user.applications.index', { status: 'approved' }),
        icon: CheckBadgeIcon,
        accent: 'text-sky-300',
        border: 'hover:border-sky-300/70',
        note: 'Ready for the stage',
    },
    {
        label: 'Tickets Purchased',
        value: props.stats.ticketsPurchased,
        href: route('user.tickets.index'),
        icon: TicketIcon,
        accent: 'text-violet-300',
        border: 'hover:border-violet-300/70',
        note: 'Event access',
    },
];

const actionToneClasses = {
    gold: {
        icon: 'text-[#D4AF37] bg-[#D4AF37]/10 ring-[#D4AF37]/20',
        hover: 'hover:border-[#D4AF37]/70 hover:shadow-[#D4AF37]/10',
        button: 'bg-[#D4AF37] text-[#140f04]',
    },
    blue: {
        icon: 'text-sky-300 bg-sky-400/10 ring-sky-300/20',
        hover: 'hover:border-sky-300/70 hover:shadow-sky-400/10',
        button: 'bg-sky-400 text-[#03121d]',
    },
    emerald: {
        icon: 'text-emerald-300 bg-emerald-400/10 ring-emerald-300/20',
        hover: 'hover:border-emerald-300/70 hover:shadow-emerald-400/10',
        button: 'bg-emerald-300 text-[#06150f]',
    },
};
</script>

<template>
<Head title="Dashboard" />
<AuthenticatedLayout>
    <div class="min-h-screen w-full bg-[#050505] px-1 py-4 sm:px-2 lg:px-0">
        <div class="mx-auto max-w-7xl space-y-6">

            <!-- Welcome -->
            <section class="relative overflow-hidden rounded-lg border border-white/10 bg-[linear-gradient(135deg,#111111_0%,#080808_50%,#15100a_100%)] shadow-2xl shadow-black/30">
                <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent"></div>
                <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div class="space-y-5">
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#D4AF37]/25 bg-[#D4AF37]/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-[#F2E29F]">
                            <!-- <SparklesIcon class="h-4 w-4" /> -->
                            Business Awards Portal
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-400">Welcome back</p>
                            <h1 class="mt-2 max-w-3xl text-3xl font-bold text-white sm:text-4xl lg:text-5xl">
                                <span class="text-gold-gradient">{{ user.name }}</span>
                            </h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-400 sm:text-base">
                                Manage applications, ticket activity, and your awards journey from one polished command center.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 rounded-lg border border-white/10 bg-black/25 p-3">
                        <div class="min-w-[5rem] rounded-lg border border-white/10 bg-white/[0.03] p-4 text-center">
                            <p class="text-2xl font-bold text-white">{{ props.stats.totalApplications }}</p>
                            <p class="mt-1 text-[11px] uppercase tracking-wide text-gray-500">Apps</p>
                        </div>
                        <div class="min-w-[5rem] rounded-lg border border-white/10 bg-white/[0.03] p-4 text-center">
                            <p class="text-2xl font-bold text-amber-200">{{ props.stats.pendingApplications }}</p>
                            <p class="mt-1 text-[11px] uppercase tracking-wide text-gray-500">Pending</p>
                        </div>
                        <div class="min-w-[5rem] rounded-lg border border-white/10 bg-white/[0.03] p-4 text-center">
                            <p class="text-2xl font-bold text-sky-200">{{ props.stats.approvedApplications }}</p>
                            <p class="mt-1 text-[11px] uppercase tracking-wide text-gray-500">Approved</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Winner Celebration -->
            <section
                v-if="hasWinningApplications"
                class="relative overflow-hidden rounded-lg border border-[#D4AF37]/40 bg-[linear-gradient(135deg,#1b1307_0%,#0a0a0a_48%,#0f172a_100%)] shadow-2xl shadow-[#D4AF37]/10"
            >
                <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#F2E29F] to-transparent"></div>
                <div class="grid gap-6 p-5 sm:p-6 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        <div class="relative h-24 w-24 shrink-0 overflow-hidden rounded-lg border border-[#D4AF37]/50 bg-black/30 shadow-lg shadow-[#D4AF37]/10">
                            <img
                                v-if="firstWinningApplication.image_url"
                                :src="firstWinningApplication.image_url"
                                :alt="firstWinningApplication.nominee_name"
                                class="h-full w-full object-cover"
                            />
                            <div v-else class="flex h-full w-full items-center justify-center">
                                <TrophyIcon class="h-10 w-10 text-[#D4AF37]" />
                            </div>
                        </div>

                        <div class="min-w-0">
                            <div class="inline-flex items-center gap-2 rounded-full border border-[#D4AF37]/30 bg-[#D4AF37]/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.16em] text-[#F2E29F]">
                                <TrophyIcon class="h-4 w-4" />
                                Winner Announced
                            </div>
                            <h2 class="mt-3 text-2xl font-black text-white sm:text-3xl">
                                Congratulations, {{ firstWinningApplication.nominee_name }}!
                            </h2>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-300">
                                You have been declared winner of
                                <span class="font-bold text-[#F2E29F]">{{ firstWinningApplication.category_name }}</span>
                                for the {{ firstWinningApplication.year }} Business Awards.
                            </p>
                            <p
                                v-if="props.winningApplications.length > 1"
                                class="mt-2 text-sm font-semibold text-[#D4AF37]"
                            >
                                You have {{ props.winningApplications.length }} winning recognitions announced.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                        <Link
                            :href="firstWinningApplication.results_url || firstWinningApplication.season_url"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-[#D4AF37] px-5 py-2.5 text-sm font-bold text-[#140f04] transition hover:bg-[#F2E29F]"
                        >
                            View Results
                            <ArrowRightIcon class="h-4 w-4" />
                        </Link>
                        <Link
                            :href="route('user.applications.show', firstWinningApplication.application_id)"
                            class="inline-flex items-center justify-center gap-2 rounded-full border border-white/15 px-5 py-2.5 text-sm font-bold text-white transition hover:border-[#D4AF37]/70 hover:bg-white/5"
                        >
                            Open Application
                        </Link>
                    </div>
                </div>

                <div
                    v-if="props.winningApplications.length > 1"
                    class="grid gap-3 border-t border-white/10 bg-black/20 p-5 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <Link
                        v-for="winner in props.winningApplications.slice(1)"
                        :key="`${winner.year}-${winner.category_slug}-${winner.application_id}`"
                        :href="winner.results_url || winner.season_url"
                        class="group rounded-lg border border-white/10 bg-white/[0.03] p-4 transition hover:border-[#D4AF37]/60"
                    >
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">{{ winner.year }} Winner</p>
                        <h3 class="mt-2 text-sm font-bold text-white">{{ winner.category_name }}</h3>
                        <p class="mt-1 text-sm text-[#D4AF37]">{{ winner.nominee_name }}</p>
                    </Link>
                </div>
            </section>

            <!-- Action Cards -->
            <section class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                <Link
                    v-for="card in actionCards"
                    :key="card.title"
                    :href="card.href"
                    class="group rounded-lg border border-white/10 bg-[#0b0b0b] p-5 shadow-xl shadow-black/20 transition duration-300 hover:-translate-y-1"
                    :class="actionToneClasses[card.tone].hover"
                >
                    <div class="flex h-full flex-col justify-between gap-6">
                        <div class="space-y-4">
                            <div
                                class="inline-flex h-12 w-12 items-center justify-center rounded-lg ring-1"
                                :class="actionToneClasses[card.tone].icon"
                            >
                                <component :is="card.icon" class="h-6 w-6" />
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">{{ card.title }}</h2>
                                <p class="mt-2 text-sm leading-6 text-gray-400">{{ card.description }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span
                                class="rounded-full px-4 py-2 text-sm font-bold transition group-hover:scale-[1.03]"
                                :class="actionToneClasses[card.tone].button"
                            >
                                {{ card.action }}
                            </span>
                            <ArrowRightIcon class="h-5 w-5 text-gray-500 transition group-hover:translate-x-1 group-hover:text-white" />
                        </div>
                    </div>
                </Link>
            </section>

            <!-- Stats Cards -->
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <Link
                    v-for="stat in statCards"
                    :key="stat.label"
                    :href="stat.href"
                    class="group rounded-lg border border-white/10 bg-[#0d0d0d] p-5 shadow-lg shadow-black/20 transition duration-300 hover:-translate-y-1"
                    :class="stat.border"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-400">{{ stat.label }}</p>
                            <p class="mt-3 text-4xl font-black tracking-normal text-white">{{ stat.value }}</p>
                        </div>
                        <div class="rounded-lg bg-white/[0.04] p-3 ring-1 ring-white/10">
                            <component :is="stat.icon" class="h-6 w-6" :class="stat.accent" />
                        </div>
                    </div>
                    <div class="mt-5 flex items-center justify-between border-t border-white/10 pt-4">
                        <span class="text-xs font-semibold uppercase tracking-[0.14em] text-gray-500">{{ stat.note }}</span>
                        <ArrowRightIcon class="h-4 w-4 text-gray-600 transition group-hover:translate-x-1 group-hover:text-white" />
                    </div>
                </Link>
            </section>

            <!-- Pending Application Alert -->
            <Link
                v-if="props.pendingApplication"
                :href="route('user.applications.show', props.pendingApplication.id)"
                class="group block overflow-hidden rounded-lg border border-[#D4AF37]/30 bg-[#120f08] shadow-xl shadow-[#D4AF37]/5 transition hover:-translate-y-1 hover:border-[#D4AF37]/80"
            >
                <div class="flex flex-col gap-5 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-[#D4AF37]/10 ring-1 ring-[#D4AF37]/25">
                            <SparklesIcon class="h-6 w-6 text-[#D4AF37]" />
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#F2E29F]">Active Application</p>
                            <h3 class="mt-2 text-lg font-bold text-white">
                                {{ props.pendingApplication.category.name }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-400">
                                Status:
                                <span class="font-bold uppercase tracking-wide text-white">
                                    {{ props.pendingApplication.status.replace('_', ' ') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <span class="inline-flex items-center justify-center gap-2 rounded-full bg-[#D4AF37] px-5 py-2.5 text-sm font-bold text-[#140f04] transition group-hover:bg-[#F2E29F]">
                        Continue
                        <ArrowRightIcon class="h-4 w-4" />
                    </span>
                </div>
            </Link>
        </div>
    </div>
</AuthenticatedLayout>
</template>
