<script setup>
import { Head, Link } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { computed } from 'vue';

defineOptions({
  layout: DefaultLayout,
});

const props = defineProps({
    sponsors: Object,
    title: String,
    description: String,
    breadcrumbs: Array,
});

const hasSponsors = computed(() => {
    return props.sponsors && Object.keys(props.sponsors).length > 0;
});

const becomeSponsorHref =
  'https://wa.me/255652724557?text=' +
  encodeURIComponent(
    "Hello! I'm interested in sponsorship/partnership with Business Awards. Please share the sponsorship packages."
  );
</script>

<template>
  <Head :title="title" />

  <div class="bg-[var(--background-main)] min-h-screen pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header -->
      <div class="text-center mb-16">
        <h2 class="text-base font-semibold text-[var(--accent-primary)] tracking-wide uppercase">Our Partners</h2>
        <p class="mt-2 text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl">{{ title }}</p>
           <p class="max-w-2xl mt-4 mx-auto text-xl text-gray-400">
          {{ description }}
        </p>

        <!-- BORESHO: Kitufe cha kuona packages za udhamini -->
        <p class="mt-8">
          <Link 
            :href="route('sponsorship-packages.index')"
            class="btn-secondary inline-flex items-center gap-2"
          >
            View Sponsorship Packages
          </Link>
        </p>
      </div>

      <!-- BORESHO: Tumia component ya Sponsors kwa kila tier -->
      <div v-if="hasSponsors" class="space-y-16">
          <div v-for="(tierSponsors, tierName) in sponsors" :key="tierName" class="relative">
              <!-- Tier Title -->
              <div class="flex items-center justify-center mb-10">
                  <div class="h-px w-12 md:w-24 bg-gradient-to-r from-transparent to-[var(--accent-primary)]"></div>
                  <h3 class="mx-4 text-2xl md:text-3xl font-bold text-[var(--accent-primary)] uppercase tracking-widest text-center drop-shadow-glow">
                      {{ tierName }} Sponsors
                  </h3>
                  <div class="h-px w-12 md:w-24 bg-gradient-to-l from-transparent to-[var(--accent-primary)]"></div>
              </div>

              <!-- Sponsors Grid -->
              <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8 justify-items-center">
                  <a v-for="sponsor in tierSponsors" :key="sponsor.id" :href="sponsor.website_url" target="_blank" rel="noopener noreferrer" 
                     class="group flex items-center justify-center w-full h-40 p-6 bg-white rounded-xl shadow-lg hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] hover:scale-105 transition-all duration-300 border border-gray-200">
                      <img :src="sponsor.logo_url" :alt="sponsor.name" class="max-h-full max-w-full object-contain" />
                  </a>
              </div>
          </div>
      </div>
      <div v-else class="text-center text-gray-500 py-10">
          <p>Our valued sponsors for this year will be announced soon. Stay tuned!</p>
      </div>

      <!-- CTA -->
      <div class="mt-20 text-center">
        <p class="text-gray-400 mb-6">Interested in becoming a partner?</p>
        <a
          :href="becomeSponsorHref"
          target="_blank"
          rel="noopener noreferrer"
          class="btn-primary inline-flex items-center gap-2"
        >
          Become a Sponsor 
        </a>
        <!-- <p class="mt-3 text-sm text-gray-500">
          WhatsApp: +255 652 724 55
        </p> -->
      </div>

    </div>
  </div>
</template>
