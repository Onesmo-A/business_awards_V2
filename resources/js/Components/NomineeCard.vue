<script setup>
import VoteButton from '@/Components/VoteButton.vue';
import { Facebook, Info, Instagram, QrCode, X } from 'lucide-vue-next';
import { ref } from 'vue';
import QRCode from 'qrcode';

// Props
const props = defineProps({
  nominee: {
    type: Object,
    required: true,
  },
  categoryUrl: { // Pass the category URL from parent page
    type: String,
    required: true,
  },
  categoryName: {
    type: String,
    required: true,
  }
});

// QR Modal State
const showQR = ref(false);
const qrDataUrl = ref('');
const showBio = ref(false);

// Function to generate QR code
const generateQR = async () => {
  try {
    qrDataUrl.value = await QRCode.toDataURL(props.categoryUrl);
    showQR.value = true;
  } catch (err) {
    console.error('Failed to generate QR code', err);
  }
};

// Close QR modal
const closeQR = () => {
  showQR.value = false;
};
</script>

<template>
  <div
    class="bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-2xl border border-gray-700 hover:border-yellow-500 
           transform transition-transform duration-300 ease-in-out hover:-translate-y-2 flex flex-col overflow-hidden group w-full max-w-xs"
  >
    <!-- Image -->
    <div class="relative aspect-[1/1] max-h-[300px] bg-gray-900">
      <img
        class="h-full w-full object-cover object-top"
        :src="nominee.image_url"
        :alt="nominee.name"
        loading="lazy"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
      <button
        v-if="nominee.bio"
        type="button"
        @click="showBio = !showBio"
        :aria-label="showBio ? 'Hide nominee description' : 'Show nominee description'"
        class="absolute right-2 top-2 inline-flex h-7 w-7 items-center justify-center rounded-full border border-yellow-300/50 bg-black/70 text-yellow-200 shadow-lg backdrop-blur-sm transition hover:bg-yellow-300 hover:text-black"
        title="View description"
      >
        <X v-if="showBio" class="h-3.5 w-3.5" />
        <Info v-else class="h-3.5 w-3.5" />
      </button>
      <transition name="bio-fade">
        <div
          v-if="showBio && nominee.bio"
          class="absolute inset-x-2 bottom-14 max-h-32 overflow-y-auto rounded-lg border border-yellow-300/30 bg-black/80 p-2 text-left text-xs leading-relaxed text-gray-100 shadow-xl backdrop-blur-md"
        >
          {{ nominee.bio }}
        </div>
      </transition>
      <h3 class="absolute bottom-0 left-0 right-0 p-2 text-base sm:text-lg font-bold leading-tight text-white">
        {{ nominee.name }}
      </h3>
    </div>

    <!-- Social + Vote -->
    <div class="p-2 flex flex-col items-center flex-grow text-center">
      <!-- Social Links -->
      <div class="flex items-center gap-2 mb-2 min-h-7">
        <a
          v-if="nominee.facebook_url"
          :href="nominee.facebook_url"
          target="_blank"
          rel="noopener noreferrer"
          class="hover:opacity-80 transition"
        >
          <Facebook class="w-5 h-5 text-blue-600" />
        </a>

        <a
          v-if="nominee.instagram_url"
          :href="nominee.instagram_url"
          target="_blank"
          rel="noopener noreferrer"
          class="hover:opacity-80 transition"
        >
          <Instagram class="w-5 h-5 text-pink-500" />
        </a>

        <a
          v-if="nominee.tiktok_url"
          :href="nominee.tiktok_url"
          target="_blank"
          rel="noopener noreferrer"
          class="hover:opacity-80 transition"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-white">
            <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5" />
          </svg>
        </a>

        <!-- QR Code Button -->
        <button
          @click="generateQR"
          class="flex items-center justify-center w-7 h-7 bg-white rounded-full hover:bg-gray-200 transition"
          title="Print QR Code"
        >
          <QrCode class="w-4 h-4 text-gray-800" />
        </button>
      </div>

      <!-- Vote Button -->
      <VoteButton :nominee="nominee" />
    </div>
  </div>

  <!-- QR Code Modal -->
  <div v-if="showQR" @click.self="closeQR" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl p-6 relative max-w-sm w-full">
      <button @click="closeQR" class="absolute top-2 right-2 text-gray-700 font-bold text-lg">&times;</button>
      <div class="text-center mb-4">
        <h3 class="text-3xl md:text-4xl font-bold text-primary-gradient drop-shadow-glow mb-2">Business Awards
          
          {{ new Date().getFullYear() }}
        
        </h3>
        <p class="text-sm text-gray-600 mt-1">
          Scan to vote for <strong class="font-semibold">{{ nominee.name }}</strong>
          <br>
          in the <strong class="font-semibold">{{ categoryName }}</strong> category.
        </p>
      </div>
      <img :src="qrDataUrl" alt="QR Code" class="mx-auto mb-4" />
      <a :href="qrDataUrl" :download="`qr-code-${nominee.name.toLowerCase().replace(/\s+/g, '-')}.png`" class="btn-primary block text-center px-4 py-2 rounded">
        SCAN/Download QR
      </a>
    </div>
  </div>
</template>

<style scoped>
.bio-fade-enter-active,
.bio-fade-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.bio-fade-enter-from,
.bio-fade-leave-to {
  opacity: 0;
  transform: translateY(6px);
}
</style>
