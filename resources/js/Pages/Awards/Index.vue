<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import AwardSeasonCard from '@/Components/Awards/AwardSeasonCard.vue'; // BORESHO: Import kadi ya msimu
import WinnerCard from '@/Components/Awards/WinnerCard.vue'; // BORESHO: Import kadi ya mshindi (kwa ajili ya utafutaji)

const props = defineProps({
    title: String,
    description: String,
    awardSeasons: Array, // BORESHO: Pokea misimu ya tuzo
    searchedWinners: Object, // Search results with pagination
    showWinners: Boolean,
    filters: Object, // Current filters, e.g., 'search'
});

const search = ref(props.filters.search);

// Debounce function to prevent sending requests on every keystroke
const debounce = (fn, delay) => {
  let timeoutID = null;
  return function (...args) {
    clearTimeout(timeoutID);
    timeoutID = setTimeout(() => fn(...args), delay);
  };
};

// Watch search input and send debounced request
watch(search, debounce((value) => {
    router.get(route('awards.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));
</script>

<template>
    <Head>
        <title>{{ title }}</title>
        <meta name="description" :content="description" />
    </Head>

    <DefaultLayout>
            <!-- Header Section -->
            <section class="pt-32 pb-16 bg-[#050505] text-white relative overflow-hidden">
                <!-- Background glow -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-4xl bg-[#D4AF37] opacity-5 blur-[120px] pointer-events-none"></div>

                <div class="text-center max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                    <h1 class="text-base font-semibold leading-7 text-[#D4AF37] uppercase tracking-widest">Hall of Fame</h1>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-6xl text-gold-gradient drop-shadow-glow">
                        {{ title }}
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-400 max-w-2xl mx-auto">
                        {{ description }}
                    </p>
                </div>
            </section>

        <!-- Winners Section -->
        <section class="bg-[#050505] py-10">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <!-- Search Section -->
                <div class="max-w-lg mx-auto mb-16">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search winners by name or category..."
                        class="w-full px-5 py-3 bg-[#1a1a1a] text-white border border-[#333] rounded-full focus:ring-[#D4AF37] focus:border-[#D4AF37] transition-colors duration-300 placeholder-gray-600"
                    >
                </div>

                <!-- SEARCH RESULTS VIEW -->
                <div v-if="filters.search">
                    <div v-if="searchedWinners && searchedWinners.data.length > 0">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                            <!-- Tumia WinnerCard component kuonyesha matokeo ya utafutaji -->
                            <WinnerCard v-for="winner in searchedWinners.data" :key="winner.id" :winner="winner" />
                        </div>
                        <div class="mt-16">
                            <Pagination :links="searchedWinners.links" />
                        </div>
                    </div>
                    <div v-else class="text-center py-16">
                        <div class="bg-[#121212] border border-[#333] inline-block p-8 rounded-xl shadow-xl text-center">
                            <h3 class="text-2xl font-bold text-[#D4AF37]">No Results Found</h3>
                            <p class="mt-4 text-gray-400 max-w-lg mx-auto">
                                We couldn't find any winners matching your search for "{{ filters.search }}".
                            </p>
                        </div>
                    </div>
                </div>

                <!-- BORESHO: DEFAULT VIEW (LIST OF AWARD SEASONS) -->
                <div v-else>
                    <div v-if="showWinners && awardSeasons.length > 0">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <!-- Tumia AwardSeasonCard component kuonyesha kila msimu -->
                            <AwardSeasonCard
                                v-for="season in awardSeasons"
                                :key="season.id"
                                :season="season"
                            />
                        </div>
                    </div>
                    <div v-else class="text-center py-16">
                        <div class="bg-[#121212] border border-[#333] inline-block p-8 rounded-xl shadow-xl text-center">
                            <h3 class="text-2xl font-bold text-[#D4AF37]">Results Are Not Yet Announced</h3>
                            <p class="mt-4 text-gray-400 max-w-lg mx-auto">
                                Please check back later to see the winners of this year's Business Awards. Good luck to all nominees!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </DefaultLayout>
</template>

<style scoped>
.text-gold-gradient {
  background: linear-gradient(135deg, #BF953F 0%, #FCF6BA 25%, #B38728 50%, #FBF5B7 75%, #AA771C 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-size: 200% auto;
  animation: shine 5s linear infinite;
}

@keyframes shine {
    to {
      background-position: 200% center;
    }
}

.drop-shadow-glow {
  filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.3));
}
</style>
