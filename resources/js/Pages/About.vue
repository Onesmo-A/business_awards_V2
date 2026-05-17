<script setup>
import { Head } from '@inertiajs/vue3';
import AppHeader from '@/Components/Layout/AppHeader.vue';
import AppFooter from '@/Components/Layout/AppFooter.vue';
import PageHeader from '@/Components/Layout/PageHeader.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';

defineOptions({
  layout: DefaultLayout,
});


defineProps({
  title: String,
  description: String,
});
</script>

<template>
  <Head :title="title" />
  <AppHeader />

  <main>
    <!-- Page Header with Breadcrumb -->
    <PageHeader :title="title" class=" pt-24 sm:pt-32 " />

    <!-- About Content Section -->
    <section class="py-20 sm:py-32 bg-[var(--background-section)] a">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          <!-- Left Image -->
          <div class="group">
           
            <img src="/images/about-us.jpg" alt="business awards Event" 
                 class="rounded-xl shadow-primary-glow border-2 border-[var(--accent-primary)] group-hover:shadow-primary-glow transition-shadow duration-300">
          
            <img src="/images/about-us2.jpg" alt="business awards Event" 
                 class="rounded-xl shadow-primary-glow border-2 border-[var(--accent-primary)] group-hover:shadow-primary-glow transition-shadow duration-300 mt-8">
          
          </div>
          
          <!-- Right Content -->
          <div>
            <h2 class="text-base font-semibold leading-7 uppercase text-[var(--accent-primary)]">Our Mission</h2>
            <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl text-primary-gradient">
                  Celebrating Excellence in Business Across Africa
            </p>
            
            <p class="mt-8 text-lg text-[var(--text-primary)] leading-8">
               The Business Awards Africa were established to recognize and honor outstanding achievements of entrepreneurs, companies, and corporate leaders across the continent. Our mission is to foster excellence, innovation, and integrity in the business ecosystem.
            </p>

            <p class="mt-6 text-lg text-[var(--text-primary)] leading-8">
              Each year, we bring together industry titans, innovators, and key stakeholders to celebrate those who have demonstrated exceptional dedication, leadership, and contribution to driving the African economy forward.
            </p>

            <!-- BORESHO: Muundo mpya wa Testimonials -->
            <div class="mt-12 space-y-8">
              <!-- Testimonial 1 -->
              <figure class="rounded-xl bg-gray-50 p-6 shadow-sm ring-1 ring-gray-900/5">
                <blockquote class="text-gray-700">
                   <p>“Winning the Business Award has opened new doors for partnerships across the continent. It is a true mark of excellence.”</p>
                </blockquote>
                <figcaption class="mt-6 flex items-center gap-x-4">
                  <img class="h-12 w-12 rounded-full bg-gray-200 object-cover" src="/images/testimonials/saad-mtambule.jpg" alt="Hon. Saad Mtambule">
                  <div>
                   <div class="font-semibold text-text-primary">Alexander O. T.</div>
                    <div class="text-gray-600">CEO - Native Technology</div>
                  </div>
                </figcaption>
              </figure>
              <!-- Testimonial 2 -->
              <figure class="rounded-xl bg-gray-50 p-6 shadow-sm ring-1 ring-gray-900/5">
                <blockquote class="text-gray-700">
                  <p>“Participating in the Business Awards Africa offers more than just the chance to win trophies, it provides significant public recognition and visibility.”</p>
                </blockquote>
                <figcaption class="mt-6 flex items-center gap-x-4">
                  <img class="h-12 w-12 rounded-full bg-gray-200 object-cover" src="/images/testimonials/karim-haji.jpg" alt="Mr. Karim S. Haji">
                  <div>
                   <div class="font-semibold text-text-primary">Madam Juby Msuya</div>
                    <div class="text-gray-600">Director - Juby Enterprises</div>
                  </div>
                </figcaption>
              </figure>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped></style>
