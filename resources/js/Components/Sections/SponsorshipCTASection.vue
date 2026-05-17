<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { BuildingOffice2Icon, HeartIcon } from '@heroicons/vue/24/outline';

const sectionRef = ref(null);

onMounted(() => {
  // Logic to add 'is-visible' class when the section enters the viewport for animation
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target); // Stop observing after it becomes visible
        }
      });
    },
    { threshold: 0.1 } // Trigger animation when 10% of section is visible
  );

  if (sectionRef.value) {
    observer.observe(sectionRef.value);
  }
});
</script>

<template>
  <div class="bg-[#121212] overflow-hidden py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="relative rounded-3xl overflow-hidden bg-black/40 border border-white/5 shadow-2xl isolate flex flex-col lg:flex-row">
        
        <!-- Text Section -->
        <div ref="sectionRef" class="relative z-10 lg:w-1/2 px-8 py-12 lg:py-20 flex flex-col justify-center">
          <div class="max-w-xl">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl mb-4">
              Partner With Excellence
            </h2>
            <p class="text-lg font-medium text-[var(--accent-primary)] mb-4">
              Showcase Your Brand to Africa's Business Leaders
            </p>
            <p class="text-base leading-7 text-gray-400 mb-8">
              Gain unique visibility and connect with innovators driving the African economy. Join us in celebrating success.
            </p>
            
	            <div class="flex">
	              <Link :href="route('sponsors.index')" class="btn-primary">
	                Become a Sponsor
	              </Link>
	            </div>
	          </div>
	        </div>

        <!-- Image Section with Transparent Gradient -->
        <div class="relative h-64 lg:h-auto lg:w-1/2 w-full">
          <img class="absolute inset-0 h-full w-full object-cover" src="/images/sponsorship-promo.jpg" alt="Sponsorship" />
          <!-- Gradient Overlay: Fades from the background color into the image -->
          <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-[#121212] via-[#121212]/70 to-transparent"></div>
        </div>
      </div>
    </div>
  </div>
</template>
