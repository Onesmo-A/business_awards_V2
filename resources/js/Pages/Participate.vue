<script setup>
import { Head } from '@inertiajs/vue3';
import AppHeader from '@/Components/Layout/AppHeader.vue';
import AppFooter from '@/Components/Layout/AppFooter.vue';
import PageHeader from '@/Components/Layout/PageHeader.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';

defineOptions({
  layout: DefaultLayout,
});


defineProps({
  title: String,
  forms: Array,
});
</script>

<template>
  <Head :title="title" />
  <AppHeader />

  <main>
    <PageHeader :title="title"class="pt-24 sm:pt-32" />

    <section class="bg-[var(--background-main)] py-20 sm:py-32 text-white">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-base font-semibold leading-7 text-[var(--accent-primary)] uppercase tracking-wider">Participate</h2>
          <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl text-red-gradient">
            Apply Online in Minutes
          </p>
          <p class="mt-6 max-w-3xl mx-auto text-lg leading-8 text-gray-300">
            Create your account to complete category applications online, save your progress securely, and track every submission from one dashboard.
          </p>
        </div>

        <div class="max-w-3xl mx-auto bg-[var(--background-section)]/90 p-8 sm:p-10 rounded-2xl border border-[var(--accent-primary)]/30 shadow-primary-glow">
          <h3 class="text-2xl font-bold text-[var(--text-accent)] text-center">Start Your Application Today</h3>
          <p class="mt-4 text-gray-300 text-center">
            Join the Business Awards platform and apply for the category that matches your impact without paperwork or long queues.
          </p>
          <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/register" class="inline-block text-center bg-[var(--accent-primary)] text-black font-bold py-3 px-6 rounded-md shadow hover:scale-105 transition-transform duration-300">
              Create Account
            </a>
            <a href="/login" class="inline-block text-center bg-transparent border border-[var(--accent-primary)] text-[var(--text-primary)] font-bold py-3 px-6 rounded-md shadow hover:scale-105 transition-transform duration-300">
              Log In
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <AppFooter />
</template>

<style scoped>
.text-red-gradient {
  background: linear-gradient(to right, #BF953F, #FCF6BA, #AA771C);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
</style>
