<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  season: Object
});
</script>

<template>
  <Link :href="route('awards.seasons.show', { year: season.year })">
    <div
      class="group rounded-lg overflow-hidden bg-gradient-to-br from-gray-900 to-black shadow-lg hover:scale-105 transition-transform duration-300 cursor-pointer h-full flex flex-col"
    >
      <div class="h-48 overflow-hidden">
        <img
          :src="season.cover_image_url || '/images/backgrounds/awards-bg.jpg'"
          :alt="season.theme"
          class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
          loading="lazy"
        />
      </div>
      <div class="p-6 text-center flex-grow flex flex-col justify-between">
        <div>
            <h3 class="text-yellow-400 text-2xl font-bold">{{ season.year }}</h3>
            <p class="text-sm text-gray-300 mt-1">{{ season.theme }}</p>
        </div>
        <span class="mt-4 inline-block text-sm text-yellow-300/80 group-hover:text-yellow-400 transition font-semibold">View Winners &rarr;</span>
      </div>
    </div>
  </Link>
</template>
