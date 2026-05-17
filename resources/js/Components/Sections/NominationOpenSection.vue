<script setup>
import { ref } from 'vue';
import NominationInfoModal from '@/Components/Modals/NominationInfoModal.vue';

defineProps({
    title: String,
    dates: String,
    timeline: Array, // BORESHO: Pokea data ya timeline
});

const showModal = ref(false);
</script>

<template>
  <section class="relative bg-[var(--background-section)] overflow-hidden">
    <!-- Background Glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-7xl pointer-events-none">
       <div class="absolute top-0 left-1/4 w-96 h-96 bg-[var(--accent-primary)]/5 rounded-full blur-3xl"></div>
       <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-[var(--accent-primary)]/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Content -->
    <div class="relative container mx-auto px-4">
      <div class="text-center bg-[#121212] p-8 md:p-12 rounded-2xl shadow-2xl border border-gray-800 relative z-10">

        <!-- Heading -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-primary-gradient mb-4 drop-shadow-lg">
          {{ title }}
        </h1>
        <h3 class="mt-2 text-2xl md:text-3xl font-bold tracking-tight text-white sm:text-4xl mb-8 border-b border-gray-800 pb-8 inline-block" >{{ dates }}</h3>
        <!-- Subheading / Description -->
        <!-- <p class="text-gray-400 text-lg mb-8 max-w-2xl mx-auto">
          Wahi sasa! Hii ni fursa yako ya kipekee kushiriki na kupewa heshima kwa juhudi zako.
        </p> -->

        <!-- BORESHO: Sehemu ya Timeline ya Matukio -->
        <div v-if="timeline && timeline.length" class="mt-2 pt-2">
            <h4 class="text-xl font-bold text-[var(--accent-primary)] mb-10 uppercase tracking-widest">Event Timeline</h4>
            <!-- Horizontal Timeline -->
            <div class="timeline-horizontal-container">
              <div v-for="(step, index) in timeline.filter(s => s.title && s.date)" :key="index" class="timeline-step">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                  <p class="timeline-title">{{ step.title }}</p>
                  <p class="timeline-date">{{ step.date }}</p>
                </div>
                <!-- Mstari unaounganisha hatua -->
                <div class="timeline-line"></div>
              </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-12 flex flex-wrap justify-center items-center gap-4">
          <!-- Apply Now Button -->
          <a href="/login"
             class="btn-primary inline-block rounded-lg px-8 py-4 font-semibold text-secondary shadow-lg transition hover:scale-105 text-center">
            Apply for Nomination
	          </a>
	          <!-- Marathon Button -->
		          <a href="/sponsors"
		             class="btn-secondary inline-block rounded-lg px-8 py-4 font-semibold text-[var(--accent-primary)] border border-[var(--accent-primary)] shadow-lg transition hover:scale-105 text-center">
		            Become a Sponsor
		          </a>
	        </div>

      </div>
    </div>

    <NominationInfoModal :show="showModal" @close="showModal = false" />

  </section>
</template>

<style scoped>

/* Optional: hide content until Vue compiles */
[v-cloak] { display: none; }

/* CSS Mpya kwa ajili ya Horizontal Timeline */
.timeline-horizontal-container {
  display: flex;
  flex-direction: column; /* Stack on mobile */
  justify-content: space-between;
  width: 100%;
  padding: 1rem 0;
}

.timeline-step {
  position: relative;
  display: flex;
  flex-direction: row; /* Horizontal layout on larger screens */
  align-items: flex-start;
  flex: 1;
  padding-bottom: 2rem; /* Space for mobile view */
}

.timeline-dot {
  width: 1.25rem; /* 20px */
  height: 1.25rem; /* 20px */
  background-color: var(--accent-primary);
  border: 4px solid #121212;
  border-radius: 9999px;
  z-index: 10;
  flex-shrink: 0;
}

.timeline-content {
  margin-left: 1rem;
  margin-top: -0.25rem; /* Align with dot */
}

.timeline-title { font-weight: 600; color: white; }
.timeline-date { font-size: 0.875rem; color: var(--accent-secondary); }

/* Mstari wa kuunganisha (Mobile View) */
.timeline-line {
  display: block;
  position: absolute;
  top: 1.25rem; /* Anzia chini ya kidoti */
  left: 0.625rem; /* Weka katikati ya kidoti */
  transform: translateX(-50%);
  width: 2px;
  height: calc(100% - 1.25rem); /* Urefu wote uliobaki */
  background-color: #333;
  z-index: 1;
}

/* Ficha mstari kwenye hatua ya mwisho */
.timeline-step:last-child .timeline-line { display: none; }

@media (min-width: 768px) { /* md breakpoint */
  .timeline-horizontal-container { flex-direction: row; }
  .timeline-step { flex-direction: column; align-items: center; text-align: center; padding-bottom: 0; }
  .timeline-content { margin-left: 0; margin-top: 1rem; }
  .timeline-line {
    position: absolute;
    top: 0.625rem; /* Half of dot height */
    left: 50%;
    width: 100%;
    height: 2px;
    background-color: #333;
    z-index: 1;
    transform: none; /* Ondoa transform ya mobile */
  }

  /* Ficha mstari kwenye hatua ya mwisho (Desktop) */
  .timeline-step:last-child .timeline-line { display: none; }
}
</style>
