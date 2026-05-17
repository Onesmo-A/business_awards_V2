<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  category: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <Link
    :href="route('categories.show', category.slug)"
    class="group relative block h-full w-full overflow-hidden rounded-xl
           bg-[#121212] text-white transition-all duration-300
           hover:scale-105 hover:shadow-2xl hover:shadow-[var(--accent-primary)]/20"
  >
    <!-- Gold Gradient Border Effect -->
    <div class="absolute inset-0 rounded-xl p-[1px] bg-gradient-to-br from-gray-800 to-gray-800 group-hover:from-[var(--accent-primary)] group-hover:to-[var(--accent-secondary)] transition-all duration-500">
      <div class="absolute inset-0 bg-[#121212] rounded-xl"></div>
    </div>

    <!-- Optional subtle image -->
    <img
      v-if="category.image_url"
      :src="category.image_url"
      :alt="category.name"
      class="w-full h-full object-cover opacity-5 transition-transform duration-500 ease-in-out group-hover:scale-105"
      loading="lazy"
      decoding="async"
    />

    <!-- Centered Content -->
    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center z-10 h-full">
      <div class="transition-transform duration-300 group-hover:scale-105">
        <h3 class="text-2xl font-bold text-white drop-shadow-md group-hover:text-yellow-400 transition-colors">
          {{ category.name }}
        </h3>
        
        <!-- Nominees count -->
        <p v-if="category.nominees_count > 0" class="mt-2">
          <span class="text-3xl font-bold text-yellow-500 drop-shadow-sm">
            {{ category.nominees_count }}
          </span>
          <span class="ml-1 text-base font-medium text-gray-400">
            Nominee<span v-if="category.nominees_count !== 1">s</span>
          </span>
        </p>
      </div>
    </div>
  </Link>
</template>
