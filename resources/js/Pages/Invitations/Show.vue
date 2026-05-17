<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import {
    CalendarDays,
    MapPin,
    Clock,
    Sparkles,
    CircleCheck,
    CircleX,
} from 'lucide-vue-next';

import { computed } from 'vue';

const props = defineProps({
    invitation: Object,
    rsvpUrl: String,
    seo: Object,
});

// Prevent default layout (AuthenticatedLayout) from being applied
defineOptions({ layout: null });

const page = usePage();
const flash = computed(() => page.props.flash);

const form = useForm({
    status: '',
});

const submitRsvp = (status) => {
    form.status = status;
    form.post(props.rsvpUrl, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="seo?.title || `Invitation for ${invitation.guest_name}`">
        <meta v-if="seo?.description" name="description" :content="seo.description" />
        <meta v-if="seo?.title" property="og:title" :content="seo.title" />
        <meta v-if="seo?.description" property="og:description" :content="seo.description" />
        <meta v-if="seo?.image" property="og:image" :content="seo.image" />
        <meta v-if="seo?.title" name="twitter:title" :content="seo.title" />
        <meta v-if="seo?.description" name="twitter:description" :content="seo.description" />
        <meta v-if="seo?.image" name="twitter:image" :content="seo.image" />
    </Head>

    <div
        class="min-h-screen bg-gray-900 text-white font-serif flex items-center justify-center p-4 sm:p-6 lg:p-8"
        style="background-image: url('/images/background-pattern.png'); background-size: cover; background-position: center;"
    >
        <div
            class="max-w-2xl w-full bg-gradient-to-br from-gray-900 via-black to-gray-900 bg-opacity-80 backdrop-blur-lg rounded-2xl shadow-2xl shadow-yellow-500/10 border border-yellow-500/30 overflow-hidden"
        >
            <header class="text-center p-6 sm:p-8 relative overflow-hidden">
                <!-- Decorative element -->
                <div class="absolute -top-12 -left-12 w-32 h-32 border-2 border-yellow-500/20 rounded-full"></div>
                <div class="absolute -bottom-16 -right-12 w-40 h-40 border border-yellow-500/10 rounded-full"></div>

                <p class="text-sm tracking-wider text-yellow-400 uppercase font-sans z-10 relative">
                    You are cordially invited to the
                </p>
                <h1
                    class="text-4xl sm:text-5xl font-bold text-white mt-2 font-sans tracking-tight drop-shadow-lg z-10 relative"
                    style="text-shadow: 0 0 15px rgba(212, 175, 55, 0.3);"
                >
                    {{ invitation.event_name }}
                </h1>
                <p v-if="invitation.event_description" class="mt-4 text-sm text-gray-300 max-w-lg mx-auto leading-relaxed z-10 relative">
                    {{ invitation.event_description }}
                </p>
            </header>

            <main class="p-6 sm:p-8 text-center border-t-2 border-yellow-600/30" style="border-image: linear-gradient(to right, transparent, #D4AF37, transparent) 1;">
                <div class="mb-8">
                    <p class="text-gray-300 text-lg">This special invitation is extended to:</p>
                    <h2
                        class="text-4xl sm:text-6xl font-semibold text-yellow-300 mt-2 font-serif italic"
                        style="text-shadow: 0 0 20px rgba(252, 211, 77, 0.4);"
                    >
                        {{ invitation.guest_name }}
                    </h2>
                    <p
                        v-if="invitation.guest_title"
                        class="text-gray-400 text-md mt-1 font-sans"
                    >
                        {{ invitation.guest_title }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left my-8 p-6 bg-black/20 rounded-xl border border-white/10">
                    <div class="flex items-center gap-4">
                        <CalendarDays
                            class="h-8 w-8 text-yellow-500 flex-shrink-0"
                        />
                        <div>
                            <h3 class="font-bold text-white uppercase text-xs tracking-wider">Date</h3>
                            <p class="text-gray-300 text-lg">{{ invitation.event_date }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <Clock
                            class="h-8 w-8 text-yellow-500 flex-shrink-0"
                        />
                        <div>
                            <h3 class="font-bold text-white uppercase text-xs tracking-wider">Time</h3>
                            <p class="text-gray-300 text-lg">{{ invitation.event_time }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <MapPin
                            class="h-8 w-8 text-yellow-500 flex-shrink-0"
                        />
                        <div>
                            <h3 class="font-bold text-white uppercase text-xs tracking-wider">Location</h3>
                            <p class="text-gray-300 text-lg">{{ invitation.event_venue }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <Sparkles
                            class="h-8 w-8 text-yellow-500 flex-shrink-0"
                        />
                        <div>
                            <h3 class="font-bold text-white uppercase text-xs tracking-wider">Dress Code</h3>
                            <p class="text-gray-300 text-lg">{{ invitation.dress_code }}</p>
                        </div>
                    </div>
                </div>

                <!-- =========== RSVP SECTION =========== -->
                <div class="mt-8">
                    <!-- If guest hasn’t responded -->
                    <div v-if="invitation.rsvp_status === 'pending'">
                        <p class="text-lg text-gray-200 mb-4">
                            Kindly confirm your attendance by RSVP:
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <button
                                @click="submitRsvp('attending')"
                                :disabled="form.processing"
                                class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-6 rounded-lg transition duration-300 disabled:opacity-50 shadow-lg hover:shadow-green-500/40 transform hover:-translate-y-1"
                            >
                                <CircleCheck class="h-6 w-6" />
                                I Will Attend
                            </button>
                            <button
                                @click="submitRsvp('declined')"
                                :disabled="form.processing"
                                class="flex items-center justify-center gap-2 bg-red-700 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 disabled:opacity-50 shadow-lg hover:shadow-red-500/40 transform hover:-translate-y-1"
                            >
                                <CircleX class="h-6 w-6" />
                                Unable to Attend
                            </button>
                        </div>
                    </div>

                    <!-- Flash messages -->
                    <div
                        v-if="flash.success"
                        class="mt-6 p-4 bg-green-500/20 border border-green-500 rounded-lg text-green-300"
                    >
                        {{ flash.success }}
                    </div>
                    <div
                        v-if="flash.warning"
                        class="mt-6 p-4 bg-yellow-500/20 border border-yellow-500 rounded-lg text-yellow-300"
                    >
                        {{ flash.warning }}
                    </div>

                    <!-- If guest already confirmed attending -->
                    <div
                        v-if="invitation.rsvp_status === 'attending' && !flash.success"
                        class="mt-6 p-4 bg-blue-500/20 border border-blue-500 rounded-lg text-blue-300"
                    >
                        Thank you for confirming your attendance. We look forward to welcoming you!
                    </div>

                    <!-- If guest already declined -->
                    <div
                        v-if="invitation.rsvp_status === 'declined' && !flash.success"
                        class="mt-6 p-4 bg-gray-500/20 border border-gray-500 rounded-lg text-gray-300"
                    >
                        You have declined the invitation. We are sorry you cannot make it.
                    </div>
                </div>

                <p class="text-gray-400 italic mt-8 text-sm">
                    Your presence will be a great honor.
                </p>
            </main>

            <footer class="text-center p-6 bg-black bg-opacity-30 border-t border-yellow-500/20">
                <img
                    src="/images/logo.png"
                    alt="Business Awards Logo"
                    class="h-12 mx-auto"
                />
            </footer>
        </div>
    </div>
</template>
