<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { developerBrand } from '@/constants/developer'

const developerInstagramUrl = 'https://www.instagram.com/nativetechnology_tz/'

const props = defineProps({
  endDate: {
    type: String,
    required: true,
  },
})

const votingEndDate = computed(() => new Date(props.endDate))
const days = ref(0)
const hours = ref(0)
const minutes = ref(0)
const seconds = ref(0)
const isVotingOver = ref(false)

let intervalId

const updateCountdown = () => {
  const now = new Date().getTime()
  const timeDifference = votingEndDate.value.getTime() - now

  if (timeDifference <= 0) {
    isVotingOver.value = true
    clearInterval(intervalId)
    days.value = 0
    hours.value = 0
    minutes.value = 0
    seconds.value = 0
    return
  }

  days.value = Math.floor(timeDifference / (1000 * 60 * 60 * 24))
  hours.value = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
  minutes.value = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60))
  seconds.value = Math.floor((timeDifference % (1000 * 60)) / 1000)
}

onMounted(() => {
  updateCountdown()
  intervalId = setInterval(updateCountdown, 1000)
})

onUnmounted(() => {
  clearInterval(intervalId)
})

const formatNumber = (num) => num.toString().padStart(2, '0')
const getProgress = (value, max) => (value / max) * 100

// Computed property to ensure reactivity in v-for
const timeUnits = computed(() => ({
  Days: days.value,
  Hours: hours.value,
  Minutes: minutes.value,
  Seconds: seconds.value
}))
</script>

<template>
  <div class="bg-transparent text-white pt-4 sm:py-24 flex flex-col relative z-10">
    <!-- Countdown Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 v-if="!isVotingOver" class="text-3xl md:text-4xl font-extrabold text-primary-gradient drop-shadow-glow mb-2">
        Voting Closes In
      </h2>
      <p v-if="!isVotingOver" class="text-sm sm:text-lg text-gray-400 max-w-xl mx-auto mb-2 sm:mb-6">
        Don't miss your chance to support your favorite nominees!
      </p>

      <div
        v-if="!isVotingOver"
        class="grid grid-cols-2 md:grid-cols-4 gap-y-4 md:gap-y-10 gap-x-4 md:gap-x-20 max-w-full mx-auto"
      >
        <div
          v-for="(value, label) in timeUnits"
          :key="label"
          class="flex flex-col items-center justify-center"
        >
          <div class="relative w-32 sm:w-40 md:w-56 h-32 sm:h-40 md:h-56">
	            <svg
	              viewBox="0 0 160 160"
	              class="countdown-ring absolute top-0 left-0 w-full h-full transform -rotate-90"
	              preserveAspectRatio="xMidYMid meet"
	            >
              <circle
                class="text-gray-700"
                stroke="currentColor"
                stroke-width="15"
                fill="transparent"
                r="65"
                cx="80"
                cy="80"
              />
              <circle
                class="text-[var(--accent-primary)] transition-all duration-500"
                :stroke-dasharray="408"
                :stroke-dashoffset="408 - (getProgress(value, label === 'Days' ? 365 : label === 'Hours' ? 24 : 60) / 100) * 408"
                stroke-linecap="round"
                stroke-width="15"
                fill="transparent"
                stroke="currentColor"
                r="65"
                cx="80"
                cy="80"
              />
            </svg>
	            <div class="absolute inset-0 flex items-center justify-center">
	              <span
	                class="text-4xl sm:text-5xl md:text-7xl font-bold text-primary-gradient bg-clip-text text-transparent"
	              >
	                {{ formatNumber(value) }}
	              </span>
	            </div>
          </div>
          <span class="text-xs sm:text-sm md:text-lg font-medium text-gray-300 uppercase tracking-widest">
            {{ label }}
          </span>
        </div>
      </div>

      <div v-else class="mt-8">
        <h3 class="text-2xl md:text-4xl font-extrabold text-primary-gradient drop-shadow-glow mb-4">
          Voting Has Ended!
        </h3>
        <p class="text-sm sm:text-lg text-gray-300 max-w-2xl mx-auto">
          Thank you for participating. Winners will be announced soon.
          <br />
          Follow us on Social Media
          <a href="https://www.instagram.com/businessawards_2024/" target="_blank" class="text-primary-gradient underline">
            businessawards_2024
          </a>
        </p>
        <!-- Button to Event Location -->
        <div class="mt-8">
          <a href="#event-location" class="btn-primary">
            View Event Location on Google Maps
          </a>
        </div>
      </div>
    </div>

    <!-- Footer -->
	    <div class="mt-2 sm:mt-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center border-t border-gray-700 pt-2">
	      <p class="text-gray-400 text-xs sm:text-sm">
	        Powered by
	        <a
	          :href="developerBrand.websiteUrl"
	          target="_blank"
	          rel="noopener noreferrer"
	          class="font-semibold text-primary-gradient hover:text-white transition"
	        >
	          {{ developerBrand.name }}
	        </a>
	      </p>
	      <div class="flex justify-center items-center gap-2 text-[11px] sm:text-xs mt-2 flex-wrap">
	        <a
	          :href="developerInstagramUrl"
	          target="_blank"
	          rel="noopener noreferrer"
	          aria-label="Instagram"
	          class="text-pink-500 hover:text-white transition inline-flex items-center gap-1 leading-none"
	        >
	          <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
	            <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5a4.25 4.25 0 0 0 4.25 4.25h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5ZM17.5 6.25a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5A3.5 3.5 0 1 0 12 15.5 3.5 3.5 0 0 0 12 8.5Z"/>
	          </svg>
            <span>nativetechnology_tz</span>
	        </a>
	        <a
	          :href="developerBrand.whatsappUrl"
	          target="_blank"
	          rel="noopener noreferrer"
	          aria-label="WhatsApp"
	          class="text-green-500 hover:text-white transition inline-flex items-center gap-1 leading-none"
	        >
	          <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
	            <path d="M19.05 4.94A9.94 9.94 0 0 0 12.02 2C6.5 2 2 6.49 2 12c0 1.76.46 3.49 1.32 5.02L2 22l5.13-1.34A9.96 9.96 0 0 0 12.02 22C17.53 22 22 17.51 22 12a9.93 9.93 0 0 0-2.95-7.06ZM12.02 20.3a8.25 8.25 0 0 1-4.2-1.15l-.3-.18-3.05.8.82-2.97-.2-.31A8.27 8.27 0 0 1 3.7 12c0-4.59 3.73-8.32 8.32-8.32A8.32 8.32 0 0 1 20.34 12c0 4.59-3.73 8.31-8.32 8.31Zm4.57-6.24c-.25-.12-1.47-.73-1.7-.81-.23-.08-.39-.12-.56.12-.16.25-.64.81-.78.98-.14.16-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.23-.74-.66-1.24-1.47-1.39-1.72-.15-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.12-.15.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.12-.56-1.35-.76-1.84-.2-.48-.41-.42-.56-.42h-.48c-.17 0-.43.06-.66.31-.23.25-.87.85-.87 2.08 0 1.22.89 2.4 1.02 2.57.12.16 1.75 2.67 4.23 3.74.59.25 1.05.4 1.41.51.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.14-1.18-.06-.1-.23-.16-.48-.29Z"/>
	          </svg>
            <span>{{ developerBrand.phoneDisplay }}</span>
	        </a>
	      </div>
	    </div>
	  </div>
	</template>

<style scoped>
.tick-enter-active,
.tick-leave-active {
  transition: all 0.4s ease-in-out;
}
.tick-enter-from {
  transform: translateY(100%);
  opacity: 0;
}
.tick-leave-to {
  transform: translateY(-100%);
  opacity: 0;
}
	.countdown-ring {
	  width: 100%;
	  height: 100%;
	}
circle {
  transition: stroke-dashoffset 0.5s ease;
}
</style>
