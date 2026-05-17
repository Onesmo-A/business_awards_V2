<script setup>
import { computed, ref, onMounted } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: null,
    },
});

// Ensure the iframe src is absolute and uses https when a relative or protocol-less URL
const iframeSrc = computed(() => {
    let url = props.data?.google_maps_embed_url || '';
    if (!url) return '';

    // If the stored value contains a full <iframe ...> HTML, extract the src attribute
    const iframeMatch = url.match(/<iframe[^>]*src=["']([^"']+)["'][^>]*>/i);
    if (iframeMatch && iframeMatch[1]) {
        url = iframeMatch[1];
    }

    // Trim
    url = url.trim();

    // If already absolute (starts with http/https), return as-is
    if (/^https?:\/\//i.test(url)) return url;
    // If it starts with '//' (protocol-relative), prefix with https:
    if (/^\/\//.test(url)) return `https:${url}`;
    // Otherwise prefix with https://
    return `https://${url}`;
});

const sectionRef = ref(null);

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    if (sectionRef.value) {
        observer.observe(sectionRef.value);
    }
});
</script>

<template>
    <section 
        v-if="data"
        ref="sectionRef"
        class="will-animate-section relative py-20 sm:py-32 text-white overflow-hidden bg-cover bg-center bg-fixed"
        style="background-image: url('/images/backgrounds/map-bg.jpg');"
    >
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16 animate-child-on-visible opacity-0" style="transition-delay: 200ms;">
                <h2 class="text-base font-semibold leading-7 text-yellow-400 uppercase">Event Location</h2>
                <p class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-5xl text-gold-gradient">
                    {{ data.title }}
                </p>
            </div>

            <!-- Map and Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <!-- Map -->
                <div class="lg:col-span-2 h-96 lg:h-[500px] rounded-xl overflow-hidden border-2 border-yellow-400/30 shadow-2xl shadow-yellow-500/10 animate-child-on-visible opacity-0" style="transition-delay: 400ms;">
                    <template v-if="iframeSrc">
                        <iframe
                            :src="iframeSrc"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="grayscale-[80%] invert-[90%] contrast-[1.2]"
                        ></iframe>
                    </template>
                    <div v-else class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-300">
                        <p>Map is not available. Please configure the map embed URL in the admin panel.</p>
                    </div>
                </div>

                <!-- Details -->
                <div class="animate-child-on-visible opacity-0" style="transition-delay: 600ms;">
                    <div class="bg-gray-900/50 p-8 rounded-xl border border-yellow-400/20">
                        <h3 class="text-3xl font-bold text-white mb-4">Event Venue</h3>
                        <p class="text-xl font-semibold text-yellow-400">
                            {{ data.location_name }}
                        </p>
                        <p v-if="data.description" class="text-gray-300 mt-2">{{ data.description }}</p>

                        <div class="mt-8 pt-6 border-t border-yellow-400/20 space-y-4">
                            <div v-if="data.event_date">
                                <h4 class="font-bold text-white">Date</h4>
                                <p class="text-gray-300">{{ data.event_date }}</p>
                            </div>
                            <div v-if="data.event_time">
                                <h4 class="font-bold text-white">Time</h4>
                                <p class="text-gray-300">{{ data.event_time }}</p>
                            </div>
                            <div v-if="data.dress_code">
                                <h4 class="font-bold text-white">Dress Code</h4>
                                <p class="text-gray-300">{{ data.dress_code }}</p>
                            </div>
                            <div v-else>
                                <h4 class="font-bold text-white">Dress Code</h4>
                                <p class="text-gray-300">Not specified</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.text-gold-gradient {
  background: linear-gradient(to right, #FFD700, #FFA500, #FFD700);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.is-visible .animate-child-on-visible {
    opacity: 1;
    transform: translateY(0);
    transition: opacity 0.8s cubic-bezier(0.215, 0.610, 0.355, 1.000), transform 0.8s cubic-bezier(0.215, 0.610, 0.355, 1.000);
}

.animate-child-on-visible {
    transform: translateY(40px);
}
</style>