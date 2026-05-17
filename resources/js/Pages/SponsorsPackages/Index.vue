<script setup>
import { Head, Link } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { CheckIcon } from '@heroicons/vue/24/solid';

defineOptions({
  layout: DefaultLayout,
});

const props = defineProps({
    packages: {
        type: [Array, Object],
        default: () => [],
    },
});

// Helper kushughulikia data ikiwa imepaginatiwa au la
const packagesList = props.packages.data || props.packages;
</script>

<template>
  <Head title="Sponsorship Packages" />

  <div class="bg-[var(--background-main)] min-h-screen pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h2 class="text-base font-semibold text-[var(--accent-primary)] tracking-wide uppercase">Partnership Opportunities</h2>
        <p class="mt-2 text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl">Sponsorship Packages</p>
        <p class="max-w-2xl mt-4 mx-auto text-xl text-gray-400">
          Elevate your brand by partnering with the Business Awards. Choose a package that suits your marketing goals.
        </p>
      </div>

      <div v-if="packagesList && packagesList.length > 0" class="mt-16 grid gap-8 lg:grid-cols-3 lg:gap-x-8">
        <div v-for="pkg in packagesList" :key="pkg.id" class="relative p-8 bg-[#121212] border border-gray-800 rounded-2xl shadow-lg flex flex-col transition-all duration-300 hover:border-[#D4AF37] hover:shadow-[0_0_30px_rgba(212,175,55,0.2)] group">
          
          <!-- Decorative element -->
          <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-1 bg-[#D4AF37] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

          <div class="flex-1">
            <h3 class="text-2xl font-bold text-white text-center mb-2">{{ pkg.name }}</h3>
            <div class="flex justify-center items-baseline my-6">
              <span class="text-4xl font-extrabold text-[#D4AF37] tracking-tight">TSh {{ new Intl.NumberFormat('sw-TZ').format(pkg.price) }}</span>
            </div>
            <p class="text-gray-400 text-sm text-center mb-6">{{ pkg.description }}</p>
            
            <div class="w-full h-px bg-gray-800 my-6 group-hover:bg-gray-700 transition-colors"></div>

            <!-- Benefits List -->
            <ul role="list" class="space-y-4">
              <li v-for="(benefit, index) in pkg.benefits" :key="index" class="flex items-start">
                <CheckIcon class="flex-shrink-0 w-5 h-5 text-[#D4AF37]" aria-hidden="true" />
                <span class="ml-3 text-gray-300 text-sm">{{ benefit }}</span>
              </li>
            </ul>
          </div>

          <a href="https://wa.me/255652724557?text=Hello,%20I%20am%20interested%20in%20becoming%20a%20sponsor." target="_blank" class="mt-8 block w-full py-3 px-6 border border-[#D4AF37] rounded-lg text-center font-bold text-[#1a0505] bg-gradient-to-r from-[#BF953F] via-[#FBF5B7] to-[#AA771C] hover:bg-none hover:bg-[#D4AF37] transition-all duration-300 shadow-[0_4px_14px_0_rgba(212,175,55,0.39)]">
            Become a Sponsor
          </a>
        </div>
      </div>
      
      <div v-else class="mt-16 text-center text-gray-500">
          <p>Sponsorship packages will be announced soon.</p>
      </div>
      
      <!-- Custom Package CTA -->
      <div class="mt-16 bg-gray-800/30 rounded-2xl p-8 text-center border border-gray-700">
          <h3 class="text-xl font-bold text-white">Need a Custom Package?</h3>
          <p class="mt-2 text-gray-400 max-w-2xl mx-auto">We understand that every brand is unique. Contact us to discuss a tailored sponsorship package that meets your specific needs.</p>
          <a href="https://wa.me/255652724557?text=Hello,%20I%20need%20a%20custom%20sponsorship%20package." target="_blank" class="mt-6 inline-block px-8 py-3 border border-[#D4AF37] text-[#D4AF37] font-bold rounded-lg hover:bg-[#D4AF37] hover:text-black transition-colors uppercase tracking-wider">
              Contact Us
          </a>
      </div>
    </div>
  </div>
</template>
