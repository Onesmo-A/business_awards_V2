<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppHeader from '@/Components/Layout/AppHeader.vue';
import AppFooter from '@/Components/Layout/AppFooter.vue';
import PageHeader from '@/Components/Layout/PageHeader.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';

defineOptions({
  layout: DefaultLayout,
});


defineProps({
  title: String,
});
</script>

<template>
  <Head :title="title" class=" pt-24 sm:pt-32 "/>
  <AppHeader />

  <main>
    <!-- Page Header -->
    <PageHeader :title="title" />

    <!-- Professional Ticket Call-to-Action Section -->
    <section class="relative bg-background-main text-white py-32 overflow-hidden">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-accent-primary text-base font-semibold uppercase tracking-wide mb-4">Business Awards Gala</h2>
        <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6 drop-shadow-lg">
          Celebrate Health Sector Excellence
        </h1>
        <p class="text-gray-300 text-lg md:text-xl mb-12 leading-relaxed">
          Be part of Tanzania's premier business awards gala. Witness outstanding achievements, network with leaders, and celebrate the innovators shaping the future of healthcare.
        </p>

        <!-- Call-to-Action Button -->
        <Link
          href="/login"
          class="btn-primary inline-block font-semibold text-lg px-10 py-5 rounded-full shadow-xl transition transform hover:scale-105"
        >
          Purchase Tickets Now, Secure Your Spot
        </Link>
      </div>

      <!-- Optional: subtle decorative shapes -->
      <div class="absolute top-0 left-0 w-32 h-32 bg-yellow-600 opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
      <div class="absolute bottom-0 right-0 w-48 h-48 bg-yellow-600 opacity-10 rounded-full translate-x-1/2 translate-y-1/2 blur-3xl"></div>
    </section>
  </main>

  <AppFooter />
</template>

<style scoped>
/* Optional: text gradient for main heading */
h1 {
  background: linear-gradient(to right, #BF953F, #FCF6BA, #B38728, #FBF5B7);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
</style>
