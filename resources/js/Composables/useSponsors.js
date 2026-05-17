// resources/js/Composables/useSponsors.js

import { ref } from 'vue';

// Hapa ndipo tutahifadhi data zote za wadhamini wetu.
// Ni rahisi kusimamia kutoka hapa.
const sponsorsList = ref([
  { name: 'natkernlimited', logo: '/images/sponsors/natkernlimited.png' },
  { name: 'uongozitalks', logo: '/images/sponsors/uongozitalks.png' },
  { name: 'pax', logo: '/images/sponsors/pax.png' },
  { name: 'whitesigns', logo: '/images/sponsors/whitesigns.png' },
  { name: 'africars', logo: '/images/sponsors/africars.png' },
  { name: 'juby', logo: '/images/sponsors/juby.png' },
  { name: 'jabal', logo: '/images/sponsors/jabal.png' },
  { name: 'psc', logo: '/images/sponsors/psc.png' },
]);

export function useSponsors() {
  return {
    sponsors: sponsorsList
  };
}