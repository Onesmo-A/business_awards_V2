<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    CalendarDaysIcon,
    CheckBadgeIcon,
    ClockIcon,
    ExclamationCircleIcon,
    QrCodeIcon,
    TicketIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    ticketTypes: Array,
    purchases: Array,
    ticketsAnnounced: Boolean,
});

const formatCurrency = (value) =>
    new Intl.NumberFormat('en-TZ', {
        style: 'currency',
        currency: 'TZS',
        minimumFractionDigits: 0,
    }).format(Number(value || 0));

const formatStatus = (status) =>
    status
        ? status.replace(/_/g, ' ').replace(/\b\w/g, (l) => l.toUpperCase())
        : 'Unknown';

const purchaseStatusClasses = {
    completed: 'bg-emerald-500/10 text-emerald-300 ring-emerald-400/20',
    pending_payment: 'bg-amber-500/10 text-amber-300 ring-amber-400/20',
    payment_failed: 'bg-red-500/10 text-red-300 ring-red-400/20',
};
</script>

<template>
<Head title="My Tickets" />

<AuthenticatedLayout>
<div class="min-h-screen space-y-6 bg-gradient-luxury-dark py-6">

    <!-- HEADER -->
    <section class="rounded-3xl border border-white/10 bg-[#0d0d0d] p-6 sm:p-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white">My Tickets</h1>
                <p class="text-sm text-gray-400 mt-2">
                    Manage and view your tickets.
                </p>
            </div>

            <div class="text-sm text-gray-300 flex items-center gap-2">
                <TicketIcon class="h-5 w-5 text-gold-300" />
                {{ ticketsAnnounced ? 'Available' : 'Not available' }}
            </div>
        </div>
    </section>

    <!-- TICKETS -->
    <section v-if="ticketsAnnounced" class="space-y-4">

        <h2 class="text-2xl font-bold text-white">Available Tickets</h2>

        <div class="grid gap-5 xl:grid-cols-3">
            <article
                v-for="ticket in ticketTypes"
                :key="ticket.id"
                class="rounded-2xl border border-white/10 bg-[#101010] p-6"
            >
                <div class="flex justify-between">
                    <h3 class="text-xl font-bold text-white">
                        {{ ticket.name }}
                    </h3>
                    <TicketIcon class="h-6 w-6 text-gold-300" />
                </div>

                <p class="mt-3 text-2xl font-bold text-white">
                    {{ formatCurrency(ticket.price) }}
                </p>

                <p class="mt-3 text-sm text-gray-400">
                    {{ ticket.description || 'No details' }}
                </p>

                <ul v-if="ticket.features?.length" class="mt-4 text-sm text-gray-300 space-y-1">
                    <li v-for="(f,i) in ticket.features" :key="i" class="flex gap-2">
                        <CheckBadgeIcon class="h-4 w-4 text-gold-300"/>
                        {{ f }}
                    </li>
                </ul>

                <Link
                    :href="route('tickets.purchase', { ticket_type_id: ticket.id })"
                    class="mt-5 block text-center bg-[#d4af37] text-black py-2 rounded-full font-semibold"
                >
                    Buy Ticket
                </Link>
            </article>
        </div>
    </section>

    <!-- NO TICKETS -->
    <section v-else class="text-center p-8 border border-dashed border-white/20 rounded-2xl">
        <ExclamationCircleIcon class="mx-auto h-12 text-gold-300" />
        <h2 class="mt-3 text-xl text-white font-bold">
            Online Tickets Not Yet Announced, Please Call +255 652 724 557!
        </h2>
    </section>

    <!-- PURCHASES -->
    <section class="space-y-4">

        <h2 class="text-2xl font-bold text-white">My Activity</h2>

        <div v-if="purchases.length" class="space-y-4">

            <article
                v-for="purchase in purchases"
                :key="purchase.id"
                class="p-6 bg-[#101010] border border-white/10 rounded-2xl"
            >
                <div class="flex justify-between flex-wrap gap-4">

                    <div>
                        <h3 class="text-lg text-white font-bold">
                            {{ purchase.ticket_type?.name || 'Ticket' }}
                        </h3>

                        <span
                            :class="purchaseStatusClasses[purchase.status]"
                            class="text-xs px-2 py-1 rounded-full"
                        >
                            {{ formatStatus(purchase.status) }}
                        </span>

                        <div class="mt-3 text-sm text-gray-400 space-y-1">
                            <div class="flex gap-2 items-center">
                                <CalendarDaysIcon class="h-4" />
                                {{ purchase.created_at }}
                            </div>

                            <div class="flex gap-2 items-center">
                                <TicketIcon class="h-4" />
                                {{ purchase.quantity }} tickets
                            </div>

                            <div class="flex gap-2 items-center">
                                <ClockIcon class="h-4" />
                                {{ formatCurrency(purchase.total_amount) }}
                            </div>

                            <div class="flex gap-2 items-center font-mono text-xs">
                                <QrCodeIcon class="h-4" />
                                {{ purchase.transaction?.order_id }}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">

                        <a
                            v-if="purchase.status === 'completed'"
                            :href="route('tickets.download', { order_id: purchase.transaction.order_id })"
                            class="bg-emerald-400 text-black px-4 py-2 rounded-full text-sm text-center"
                        >
                            Download
                        </a>

                        <Link
                            v-else-if="purchase.status === 'pending_payment'"
                            :href="route('tickets.pending', { order_id: purchase.transaction.order_id })"
                            class="bg-amber-400 text-black px-4 py-2 rounded-full text-sm text-center"
                        >
                            Continue
                        </Link>

                    </div>
                </div>

                <!-- TICKET CODES -->
                <div v-if="purchase.tickets?.length" class="mt-4">
                    <div class="grid md:grid-cols-2 gap-2">
                        <div
                            v-for="ticket in purchase.tickets"
                            :key="ticket.id"
                            class="bg-black/30 p-3 rounded"
                        >
                            <p class="text-gold-300 font-mono text-sm">
                                {{ ticket.ticket_code }}
                            </p>
                        </div>
                    </div>
                </div>
            </article>

        </div>

        <!-- EMPTY -->
        <div v-else class="text-center p-8 border border-white/10 rounded-2xl">
            <TicketIcon class="mx-auto h-10 text-gray-500"/>
            <p class="text-gray-400 mt-2">
                No activity yet.
            </p>
        </div>

    </section>

</div>
</AuthenticatedLayout>
</template>