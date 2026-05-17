<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  title: String,
  description: String,
  slides: {
    type: Array,
    default: () => [],
  },
  rotationMs: {
    type: Number,
    default: 4000, // mabadiliko ya kila 4 sekunde
  },
});

const heroSlides = computed(() => {
  if (props.slides && props.slides.length > 0) return props.slides;
  return [
    { 
      title: props.title || 'Business Awards ' + new Date().getFullYear(),
      description: props.description || 'Celebrating Excellence in Business and Innovation',
      image_url: '/images/trophy1.png', // Fallback image
      buttons: [
        { text: 'VOTE NOW →', link: '/categories', primary: true },
        { text: 'All Award Winners →', link: '/awards', primary: false },
      ]
    },
  ];
});

const currentIndex = ref(0);
let timer = null;

function next() { currentIndex.value = (currentIndex.value + 1) % heroSlides.value.length; }
function prev() { currentIndex.value = (currentIndex.value - 1 + heroSlides.value.length) % heroSlides.value.length; }
function goTo(i) { currentIndex.value = i % heroSlides.value.length; }
function start() {
  stop();
  if (heroSlides.value.length > 1) {
    timer = setInterval(next, props.rotationMs);
  }
}
function stop() { if (timer) clearInterval(timer); timer = null; }
function handleVisibility() { if (document.hidden) stop(); else start(); }

onMounted(() => {
  start();
  document.addEventListener('visibilitychange', handleVisibility);
});
onUnmounted(() => {
  stop();
  document.removeEventListener('visibilitychange', handleVisibility);
});
</script>

<template>
  <div
    class="relative min-h-screen flex items-center justify-center overflow-hidden text-white font-sans pt-20 md:pt-0 mt-0"
    @mouseenter="stop"
    @mouseleave="start"
  >
    <!-- Content -->
    <div class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 w-full grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-12 items-center h-full">
      
      <!-- Text + Buttons -->
      <div class="text-center md:text-left order-2 md:order-1 mt-10 md:mt-16">
        <Transition name="hero-crazy" mode="out-in">
          <div :key="'slide-'+currentIndex">
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold tracking-tight leading-tight animate-title drop-shadow-title">
              <span class="block mt-2 text-primary-gradient">
                {{ heroSlides[currentIndex].title }}
              </span>
            </h1>
            <p class="mt-6 text-base sm:text-lg md:text-xl text-gray-300 max-w-xl mx-auto md:mx-0 animate-description drop-shadow-lg">
              {{ heroSlides[currentIndex].description }}
            </p>

            <!-- Buttons -->
            <div class="mt-8 flex flex-col md:flex-row gap-4 justify-center md:justify-start animate-buttons">
              <Link
                v-for="(btn, i) in heroSlides[currentIndex].buttons"
                :key="i"
                :href="btn.link"
                :class="btn.primary ? 'btn-primary' : 'btn-secondary'"
              >
                {{ btn.text }}
              </Link>
            </div>
          </div>
        </Transition>

        <!-- Controls -->
        <div class="mt-8 flex items-center justify-center md:justify-start gap-4 select-none">
          <button @click="prev" class="h-10 w-10 grid place-items-center rounded-full bg-white/5 text-white border border-white/10 hover:bg-[var(--accent-primary)] hover:text-black hover:border-transparent transition duration-300">‹</button>
          <div class="flex items-center gap-2">
            <button
              v-for="(s, i) in heroSlides"
              :key="'dot-'+i"
              @click="goTo(i)"
              class="h-3 w-3 rounded-full transition-all border shadow-md"
              :class="i === currentIndex 
                ? 'bg-[var(--accent-primary)] border-[var(--accent-primary)] scale-125' 
                : 'bg-transparent border-white/20 hover:bg-white/20'"
            />
          </div>
          <button @click="next" class="h-10 w-10 grid place-items-center rounded-full bg-white/5 text-white border border-white/10 hover:bg-[var(--accent-primary)] hover:text-black hover:border-transparent transition duration-300">›</button>
        </div>
      </div>

      <!-- Image Column (Sliding Images with Gradient) -->
      <div class="relative order-1 md:order-2 h-[400px] md:h-[600px] w-full flex items-center justify-center">
        <Transition name="fade-image" mode="out-in">
          <div :key="'img-'+currentIndex" class="relative w-full h-full flex items-center justify-center">
             <!-- Image with Mask/Gradient - Adjusted for Mobile Zoom & Gradient Opacity -->
             <div class="relative w-full h-full md:w-[120%] md:-mr-[20%]">
                <img
                  :src="heroSlides[currentIndex].image_url || '/images/trophy1.png'"
                  alt="Award Highlight"
                  class="w-full h-full object-cover md:object-cover mask-gradient"
                />
                <!-- Gradient Overlay Reduced -->
                <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-[var(--background-main)]/60 via-transparent to-transparent opacity-80 md:opacity-100"></div>
             </div>
          </div>
        </Transition>
      </div>

    </div>
  </div>
</template>

<style scoped>
/* Custom Mask for Image Blending */
.mask-gradient {
  mask-image: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 20%, rgba(0,0,0,1) 100%);
  -webkit-mask-image: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 20%, rgba(0,0,0,1) 100%);
}

/* Title Animations */
@keyframes titlePop {
  0% { opacity: 0; transform: translateY(40px) scale(0.95) rotateX(20deg); }
  60% { opacity: 1; transform: translateY(-5px) scale(1.05); }
  100% { transform: translateY(0) scale(1) rotateX(0deg); }
}
.animate-title { animation: titlePop 1.2s cubic-bezier(.22,1.28,.63,1); }

/* Description */
@keyframes descFade {
  0% { opacity: 0; transform: translateX(-40px) skewX(-10deg) scale(1.2); }
  60% { opacity: 1; transform: translateX(5px) skewX(3deg) scale(1.05); }
  100% { opacity: 1; transform: translateX(0) skewX(0) scale(1); }
}
.animate-description { 
  animation: descFade 1.5s ease-out;
  animation-fill-mode: backwards;
}

/* Buttons */
@keyframes btnPop {
  0% { opacity: 0; transform: translateY(20px) scale(0.8) rotate(-5deg); }
  70% { opacity: 1; transform: translateY(-4px) scale(1.05) rotate(3deg); }
  100% { transform: translateY(0) scale(1) rotate(0deg); }
}
.animate-buttons {
  animation: btnPop 1.3s cubic-bezier(.2,1.4,.4,1);
}

/* Slide transition wrapper */
.hero-crazy-enter-active,
.hero-crazy-leave-active {
  transition: all 0.9s cubic-bezier(.5,.05,.1,.95);
}
.hero-crazy-enter-from {
  opacity: 0;
  transform: scale(0.9) rotateY(30deg);
}
.hero-crazy-leave-to {
  opacity: 0;
  transform: scale(0.9) rotateY(-30deg);
}

/* Image Fade Transition */
.fade-image-enter-active,
.fade-image-leave-active {
  transition: opacity 1s ease, transform 1s ease;
}
.fade-image-enter-from,
.fade-image-leave-to {
  opacity: 0;
  transform: scale(1.05);
}
</style>