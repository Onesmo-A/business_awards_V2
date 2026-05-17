<script setup>
const props = defineProps({
    sponsors: {
        type: Array,
        default: () => []
    },
    title: {
        type: String,
        default: 'Our Partners'
    }
});
</script>

<template>
  <div class="py-16 bg-[#0a0a0a] border-t border-gray-900">
    <div class="container mx-auto px-6 text-center">
      <h3 class="text-2xl font-bold text-[var(--accent-primary)] mb-10 uppercase tracking-widest">{{ title }}</h3>
      <div v-if="sponsors.length > 0" class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
        <a v-for="sponsor in sponsors" :key="sponsor.id" :href="sponsor.website_url" target="_blank" rel="noopener noreferrer" class="h-12 md:h-16 flex items-center" :title="sponsor.name">
          <img :src="sponsor.logo_url" :alt="sponsor.name" class="max-h-full w-auto object-contain grayscale hover:grayscale-0 transition duration-500 opacity-60 hover:opacity-100" />
        </a>
      </div>
      <div v-else>
        <p class="text-gray-500">Sponsors will be announced soon.</p>
      </div>
    </div>
  </div>
</template>
