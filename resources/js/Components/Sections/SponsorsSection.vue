<script setup>
import { computed } from 'vue'

const props = defineProps({
    sponsors: {
        type: Object, // The data comes grouped by tier from the controller
        default: () => ({})
    }
});

const scrollingSponsors = computed(() => {
  // Flatten the sponsors object into a single array
  const allSponsors = Object.values(props.sponsors).flat();
  if (!allSponsors || allSponsors.length === 0) return [];
  // Duplicate the array for a seamless scrolling effect
  return [...allSponsors, ...allSponsors];
});
</script>

<template>
  <section
    class="relative py-20 sm:py-32 text-white overflow-hidden bg-cover bg-center bg-fixed"
    style="background-image: url('/images/backgrounds/sponsors-bg.jpg');"
  >
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    <div class="relative z-10">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- HEADER (UNCHANGED) -->
        <div class="text-center mb-16">
          <h2
            class="text-base font-semibold leading-7 uppercase"
            style="color: var(--accent-color)"
          >
            Our Valued Partners
          </h2>

          <p class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-5xl text-primary-gradient">
            Proudly Sponsored By
          </p>
        </div>

        <!-- BIG LOGO ROW -->
        <div v-if="scrollingSponsors.length > 0" class="scroller">
          <div class="scroller__inner">
            <a
              v-for="(sponsor, index) in scrollingSponsors"
              :key="`sponsor-${index}`"
              class="logo-wrapper"
              :href="sponsor.website_url"
              target="_blank"
              rel="noopener noreferrer"
              :title="sponsor.name"
            >
              <img
                :src="sponsor.logo_url"
                :alt="sponsor.name"
                class="sponsor-logo"
              />
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<style scoped>

/* BIG ROW */
.scroller {
  overflow: hidden;
  height: 260px;
  -webkit-mask: linear-gradient(90deg, transparent, white 15%, white 85%, transparent);
  mask: linear-gradient(90deg, transparent, white 15%, white 85%, transparent);
}

/* FLEX */
.scroller__inner {
  display: flex;
  align-items: center;
  gap: 120px;
  width: max-content;
  height: 100%;
  animation: scroll 75s linear infinite; /* SLOWER */
}

/* PAUSE ON HOVER */
.scroller:hover .scroller__inner {
  animation-play-state: paused;
}

@keyframes scroll {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
}

/* LOGO CONTAINER */
.logo-wrapper {
  height: 100%;
  width: 300px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* LOGO */
.sponsor-logo {
  width: 100%;
  height: 100%;
  object-fit: contain;
  transition: transform 0.3s ease;
}

.sponsor-logo:hover {
  transform: scale(1.05);
}

/* MOBILE */
@media (max-width: 768px) {
  .scroller {
    height: 160px;
  }

  .logo-wrapper {
    width: 200px;
  }

  .scroller__inner {
    gap: 60px;
    animation-duration: 55s; /* slower mobile */
  }
}

</style>
