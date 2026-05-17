<script setup>
import { Head } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import VoteButton from '@/Components/VoteButton.vue';
import { Facebook, Instagram } from 'lucide-vue-next';

defineOptions({
  layout: DefaultLayout,
});

defineProps({
  nominee: Object,
  category: Object
});
</script>

<template>
  <Head :title="nominee.name" />

  <div class="pt-32 pb-16 bg-background-main min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Nominee Image -->
        <div class="relative">
          <img 
            :src="nominee.image_url" 
            :alt="nominee.name"
            class="rounded-xl shadow-2xl w-full aspect-[4/3] object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent rounded-xl"></div>
        </div>

        <!-- Nominee Info -->
        <div class="space-y-6">
          <div>
            <h1 class="text-4xl font-bold text-primary-gradient">{{ nominee.name }}</h1>
            <p class="text-yellow-400 mt-2">{{ category.name }}</p>
          </div>

          <div class="prose prose-lg prose-invert">
            <p>{{ nominee.bio }}</p>
          </div>

          <!-- Social Media Links -->
          <div class="flex items-center gap-4 mt-6">
            <a
              v-if="nominee.facebook_url"
              :href="nominee.facebook_url"
              target="_blank"
              rel="noopener noreferrer"
              class="p-2 bg-gray-800 rounded-full hover:bg-blue-900/50 transition border border-gray-700 hover:border-blue-500"
            >
              <Facebook class="w-6 h-6 text-blue-500" />
            </a>
            <a
              v-if="nominee.instagram_url"
              :href="nominee.instagram_url"
              target="_blank"
              rel="noopener noreferrer"
              class="p-2 bg-gray-800 rounded-full hover:bg-pink-900/50 transition border border-gray-700 hover:border-pink-500"
            >
              <Instagram class="w-6 h-6 text-pink-500" />
            </a>
            <a
              v-if="nominee.tiktok_url"
              :href="nominee.tiktok_url"
              target="_blank"
              rel="noopener noreferrer"
              class="p-2 bg-gray-800 rounded-full hover:bg-gray-700 transition border border-gray-700 hover:border-gray-500"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5" />
              </svg>
            </a>
          </div>

          <VoteButton 
            :nominee="nominee"
            class="mt-8"
          />
        </div>
      </div>
    </div>
  </div>
</template>