<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { TrophyIcon } from '@heroicons/vue/24/solid';

defineProps({
    season: Object, // Will contain season details and categories with winners
});
</script>

<template>
    <Head :title="`Winners - ${season.theme || season.year}`" />

    <DefaultLayout>
        <div class="bg-black text-white min-h-screen">
            <!-- Header Section -->
            <header class="relative bg-gray-900 py-20 sm:py-24">
                <div class="absolute inset-0">
                    <img :src="season.cover_image_url" alt="Season Background" class="w-full h-full object-cover opacity-20" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>
                </div>
                <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
                    <p class="text-base font-semibold leading-7 text-yellow-400">Celebrating The Best Of</p>
                    <h1 class="text-4xl font-bold tracking-tight sm:text-6xl bg-gradient-to-r from-yellow-300 via-gold-500 to-yellow-300 bg-clip-text text-transparent drop-shadow-lg"
                        v-text="season.theme || `Business Awards ${season.year}`"></h1>
                    <p class="mt-6 text-lg leading-8 text-gray-300 max-w-3xl mx-auto">
                        Honoring the outstanding achievements and contributions of the most brilliant minds in the industry for the year {{ season.year }}.
                    </p>
                </div>
            </header>

            <!-- Winners Section -->
            <main class="py-10 sm:py-12">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div v-if="season.can_show_winners && season.categories.length > 0">
                        <div v-for="category in season.categories" :key="category.id" class="mb-16 last:mb-0">
                            <div class="mb-8 border-b-2 border-yellow-400/20 pb-4">
                                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">
                                    {{ category.name }}
                                </h2>
                                <p class="mt-2 text-gray-400">{{ category.description }}</p>
                            </div>

                            <div v-if="category.winner" class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                                <!-- Winner Card -->
                                <Link 
                                    :href="route('awards.results.category', { year: season.year, category: category.slug })"
                                    class="md:col-span-2 bg-gradient-to-br from-gray-900 to-black rounded-2xl p-8 border border-gold-500/30 shadow-2xl shadow-gold-500/10 hover:border-gold-500 hover:shadow-gold-500/20 transition-all duration-300 group block"
                                >
                                    <div class="flex flex-col sm:flex-row items-center gap-6">
                                        <div class="flex-shrink-0">
                                            <!-- BORESHO: Pata picha na jina kutoka kwa 'nominee' object iliyo ndani ya 'winner' -->
                                            <img :src="category.winner.nominee.image_url" :alt="category.winner.nominee.name" class="h-32 w-32 rounded-full object-cover border-4 border-gold-500 group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-yellow-400 uppercase tracking-wider">Winner {{ season.year }}</p>
                                            <h3 class="text-2xl font-bold text-white mt-1 group-hover:text-gold-400 transition-colors">{{ category.winner.nominee.name }}</h3>
                                            <p class="text-xs text-gray-500 mt-2 flex items-center group-hover:text-gray-300">
                                                View full results <span class="ml-1">&rarr;</span>
                                            </p>
                                            <!-- 'company' haipo, nimeiondoa. Unaweza kuweka 'bio' fupi hapa kama inahitajika -->
                                        </div>
                                    </div>
                                    <p v-if="category.winner.nominee.bio" class="mt-6 text-gray-400 italic">
                                        "{{ category.winner.nominee.bio }}"
                                    </p>
                                </Link>
                                <!-- Trophy Icon -->
                                <div class="hidden md:flex justify-center items-center">
                                    <TrophyIcon class="h-32 w-32 text-gold-500 opacity-50" />
                                </div>
                            </div>
                            <div v-else class="text-center py-8 bg-gray-900/50 rounded-lg border border-gray-700">
                                <p class="text-gray-400">Winner for this category is yet to be announced. Stay tuned!</p>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-16 bg-gray-900/50 rounded-lg border border-gray-700">
                        <TrophyIcon class="mx-auto h-16 w-16 text-yellow-500 opacity-50" />
                        <h2 class="mt-4 text-2xl font-bold text-white">Results Not Yet Announced</h2>
                        <p class="mt-2 text-gray-400">
                            The winners for the {{ season.year }} awards are still being finalized.
                            <br>
                            Please check back soon!
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </DefaultLayout>
</template>