<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import NominationInfoModal from '@/Components/Modals/NominationInfoModal.vue'

const showModal = ref(false)
</script>

<template>
  <div class="bg-background-section py-20 text-black scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

      <!-- Section Header -->
      <div class="text-center">
        <h2 class="text-base font-semibold leading-7 uppercase text-[var(--accent-primary)]">
          Why Participate?
        </h2>

        <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl text-primary-gradient">
          Business Awards Africa
        </p>

        <p class="mt-6 max-w-3xl mx-auto text-lg leading-8 text-gray-400">
          Business Awards Africa recognizes and celebrates visionary entrepreneurs, 
          high-growth companies, corporate leaders, and innovators who are transforming 
          industries and driving economic growth across Africa. 
          This prestigious platform positions your brand among the continent’s elite.
        </p>
      </div>

      <!-- Cards -->
      <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">

        <!-- Card 1 -->
        <div
          class="p-8 rounded-2xl border border-gray-800 shadow-md bg-[#121212]
                 hover:border-[var(--accent-primary)] hover:shadow-xl hover:-translate-y-2
                 transition-all duration-300 will-animate animate-fade-in-up"
          style="animation-delay: 0.2s;"
        >
          <div class="flex items-center justify-center h-16 w-16 rounded-full
                      bg-yellow-900/20 mx-auto mb-6 border border-yellow-700/30">
            <svg class="h-8 w-8 text-[var(--accent-primary)]" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
            </svg>
          </div>

          <h3 class="text-xl font-bold text-white">
            Continental Recognition
          </h3>

          <p class="mt-2 text-gray-400">
            Gain high-level recognition across Africa for your business excellence, 
            innovation, and measurable impact. Position your company among the most 
            influential brands on the continent.
          </p>
        </div>

        <!-- Card 2 -->
        <div
          class="p-8 rounded-2xl border border-gray-800 shadow-md bg-[#121212]
                 hover:border-[var(--accent-primary)] hover:shadow-xl hover:-translate-y-2
                 transition-all duration-300 will-animate animate-fade-in-up"
          style="animation-delay: 0.4s;"
        >
          <div class="flex items-center justify-center h-16 w-16 rounded-full
                      bg-yellow-900/20 mx-auto mb-6 border border-yellow-700/30">
            <svg class="h-8 w-8 text-[var(--accent-primary)]" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-3 0-5 2-5 4s2 4 5 4 5-2 5-4-2-4-5-4z" />
            </svg>
          </div>

          <h3 class="text-xl font-bold text-white">
            Elite Networking Opportunities
          </h3>

          <p class="mt-2 text-gray-400">
            Connect with CEOs, founders, investors, policymakers, and top executives 
            during the Awards Gala. Build strategic partnerships that accelerate 
            expansion, funding, and regional influence.
          </p>
        </div>

        <!-- Card 3 -->
        <div
          class="p-8 rounded-2xl border border-gray-800 shadow-md bg-[#121212]
                 hover:border-[var(--accent-primary)] hover:shadow-xl hover:-translate-y-2
                 transition-all duration-300 will-animate animate-fade-in-up"
          style="animation-delay: 0.6s;"
        >
          <div class="flex items-center justify-center h-16 w-16 rounded-full
                      bg-yellow-900/20 mx-auto mb-6 border border-yellow-700/30">
            <svg class="h-8 w-8 text-[var(--accent-primary)]" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 17l6-6 4 4 8-8" />
            </svg>
          </div>

          <h3 class="text-xl font-bold text-white">
            Brand Visibility & Market Growth
          </h3>

          <p class="mt-2 text-gray-400">
            Increase media exposure and brand credibility across Africa. 
            Showcase your success story, attract new clients, and strengthen 
            your position as an industry leader.
          </p>
        </div>

      </div>

      <!-- CTA Buttons -->
      <div class="mt-10 flex justify-center flex-col sm:flex-row gap-4 animate-fade-in-up"
           style="animation-delay: 1s;">

        <Link :href="route('participate')" class="btn-primary">
          Submit Nomination <span aria-hidden="true">→</span>
        </Link>

        <Link :href="route('tickets.index')" class="btn-secondary">
          Book Awards Gala Ticket <span aria-hidden="true">→</span>
        </Link>

      </div>

    </div>
  </div>

  <!-- Modal -->
  <NominationInfoModal :show="showModal" @close="showModal = false" />
</template>

<style scoped>
.will-animate {
  opacity: 0;
  animation-fill-mode: forwards;
}

@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fade-in-up 0.8s ease-out forwards;
}
</style>
