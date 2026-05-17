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
    guest: Object
});
</script>

<template>
  <Head title="Guest of Honor" />
  <AppHeader />

  <main>
    <!-- Page Header -->
    <PageHeader title="Guest of Honor" class="pt-24 sm:pt-32" />

    <!-- Content Section -->
    <section class="py-20 sm:py-32 bg-[var(--background-section)]">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div v-if="guest" class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          <!-- Image Placeholder -->
          <div class="relative group">
            <div class="absolute -inset-4 bg-gradient-to-r from-[var(--accent-primary)] to-[var(--accent-secondary)] rounded-xl opacity-30 blur-lg group-hover:opacity-50 transition duration-500"></div>

            <div class="relative rounded-xl bg-[#0a0a0a] border border-[var(--accent-dark)] w-full aspect-[3/4] flex items-center justify-center overflow-hidden">
                <img 
                    :src="guest.image_url || '/images/guest-placeholder.jpg'" 
                    :alt="guest.name"
                    class="w-full h-full object-cover rounded-xl"
                >
            </div>
          </div>
          
          <!-- Text Content -->
          <div>
            <h2 class="text-base font-semibold leading-7 uppercase text-[var(--accent-primary)] tracking-widest">{{ guest.title || 'Special Guest' }}</h2>
            <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl text-primary-gradient mb-6">
              {{ guest.name }}
            </p>
            
            <div class="space-y-6 text-lg text-[var(--text-secondary)] leading-8">
                <p v-if="guest.bio" class="whitespace-pre-line">{{ guest.bio }}</p>
                <p v-else>We are honored to welcome this year's Guest of Honor.</p>
            </div>
          </div>
        </div>

        <div v-else class="text-center py-20">
            <h3 class="text-2xl font-bold text-gray-400">Guest of Honor to be announced soon.</h3>
            <p class="mt-4 text-gray-500">Please check back later for updates.</p>
        </div>
      </div>
    </section>
  </main>
</template>