<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Autoplay } from 'swiper/modules'
import 'swiper/css'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({
  categories: Array,
})

const swiperRef = ref(null)

const setSwiper = (swiper) => {
  swiperRef.value = swiper
}

const nextSlide = () => {
  swiperRef.value?.slideNext()
}

const prevSlide = () => {
  swiperRef.value?.slidePrev()
}
</script>

<template>
  <section class="py-20 scroll-mt-20" style="background-color: var(--background-section);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

      <!-- Header -->
      <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
        <div class="text-center md:text-left w-full md:w-auto">
          <h2 class="text-base font-semibold uppercase text-[var(--accent-primary)]">
            Award Categories
          </h2>
          <p class="mt-2 text-4xl font-bold sm:text-5xl text-primary-gradient">
            Explore & Vote
          </p>
          <p class="mt-4 text-lg text-gray-400 max-w-2xl">
            Discover outstanding business categories and cast your vote 
            for Africa’s most impactful brands and leaders.
          </p>
        </div>

        <Link
          href="/categories"
          class="btn-secondary !rounded-full px-8 py-3 whitespace-nowrap hidden md:inline-block"
        >
          View All Categories
        </Link>
      </div>

      <!-- Swiper -->
      <div class="relative">

        <Swiper
          :modules="[Autoplay]"
          :slides-per-view="1"
          :space-between="24"
          :breakpoints="{
            640: { slidesPerView: 1.2 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
          }"
          :autoplay="{ delay: 5000 }"
          loop
          @swiper="setSwiper"
        >
          <SwiperSlide
            v-for="(category, index) in categories"
            :key="index"
            class="h-auto"
          >
            <div
              class="group relative bg-[#121212] rounded-2xl p-6 h-full flex flex-col justify-between
                     transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl
                     hover:shadow-[var(--accent-primary)]/20 overflow-hidden border border-gray-800"
            >
              <h3 class="text-2xl font-bold mb-4 text-white">
                {{ category.name }}
              </h3>

              <!-- Nominees -->
              <div class="flex-grow mb-6"
                   v-if="category.nominees && category.nominees.length > 0">

                <div class="flex items-center -space-x-4 mb-4">
                  <img
                    v-for="nominee in category.nominees.slice(0, 4)"
                    :key="nominee.id"
                    class="w-14 h-14 rounded-full border-2 border-gray-700 object-cover bg-gray-800"
                    :src="nominee.image_url"
                    :alt="nominee.name"
                  />
                  <div
                    v-if="category.nominees.length > 4"
                    class="flex items-center justify-center w-14 h-14 text-xs font-medium rounded-full border-2 border-gray-700 text-white bg-gray-800"
                  >
                    +{{ category.nominees.length - 4 }}
                  </div>
                </div>

                <p class="text-sm text-gray-400">
                  <span class="font-semibold text-[var(--accent-primary)]">
                    Nominees:
                  </span>
                  {{ category.nominees.map(n => n.name).join(', ') }}
                </p>
              </div>

              <!-- Vote Button -->
              <div class="mt-6">
                <Link
                  :href="route('categories.show', category.slug)"
                  class="btn-primary !w-auto !py-2"
                >
                  Vote Now
                </Link>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>

        <!-- Custom Controls (Centered Bottom) -->
        <div class="flex justify-center items-center gap-6 mt-10">
          <button
            @click="prevSlide"
            class="control-btn"
          >
            ‹
          </button>

          <button
            @click="nextSlide"
            class="control-btn"
          >
            ›
          </button>
        </div>

      </div>

      <!-- Mobile View All -->
      <div class="mt-10 text-center md:hidden">
        <Link
          href="/categories"
          class="btn-secondary !rounded-full w-full"
        >
          View All Categories
        </Link>
      </div>

    </div>
  </section>
</template>

<style scoped>
.control-btn {
  width: 48px;
  height: 48px;
  border-radius: 9999px;
  border: 2px solid var(--accent-primary);
  color: var(--accent-primary);
  font-size: 24px;
  transition: all 0.3s ease;
  background: transparent;
}

.control-btn:hover {
  background: var(--accent-primary);
  color: var(--background-main);
  transform: scale(1.1);
}
</style>
