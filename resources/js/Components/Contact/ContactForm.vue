<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: '',
});

const submit = () => {
  form.post(route('contact.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <div class="bg-[#121212] border border-gray-800 rounded-2xl p-6 sm:p-8 shadow-2xl">
    <h3 class="text-2xl font-bold text-white mb-2">Send us a message</h3>
    <p class="text-gray-400 mb-6">We’ll respond as soon as possible.</p>

    <FlashMessage />

    <div v-if="form.errors.form" class="mb-4 rounded-lg border border-red-500/30 bg-red-500/10 p-3 text-sm text-red-300">
      {{ form.errors.form }}
    </div>

    <form @submit.prevent="submit" class="space-y-5">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-300">Your Name</label>
        <input
          id="name"
          type="text"
          v-model="form.name"
          required
          autocomplete="name"
          class="mt-1 block w-full bg-gray-900/50 border-gray-700 text-gray-300 placeholder-gray-500 focus:border-gold-400 focus:ring focus:ring-gold-400 focus:ring-opacity-50 rounded-md shadow-sm"
          placeholder="John Doe"
        />
        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-300">Email Address</label>
        <input
          id="email"
          type="email"
          v-model="form.email"
          required
          autocomplete="email"
          class="mt-1 block w-full bg-gray-900/50 border-gray-700 text-gray-300 placeholder-gray-500 focus:border-gold-400 focus:ring focus:ring-gold-400 focus:ring-opacity-50 rounded-md shadow-sm"
          placeholder="you@example.com"
        />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div>
        <label for="subject" class="block text-sm font-medium text-gray-300">Subject</label>
        <input
          id="subject"
          type="text"
          v-model="form.subject"
          required
          class="mt-1 block w-full bg-gray-900/50 border-gray-700 text-gray-300 placeholder-gray-500 focus:border-gold-400 focus:ring focus:ring-gold-400 focus:ring-opacity-50 rounded-md shadow-sm"
          placeholder="How can we help?"
        />
        <InputError class="mt-2" :message="form.errors.subject" />
      </div>

      <div>
        <label for="message" class="block text-sm font-medium text-gray-300">Message</label>
        <textarea
          id="message"
          v-model="form.message"
          rows="5"
          required
          class="mt-1 block w-full bg-gray-900/50 border border-gray-700 text-gray-300 placeholder-gray-500 focus:border-gold-400 focus:ring focus:ring-gold-400 focus:ring-opacity-50 rounded-md shadow-sm p-3 resize-y"
          placeholder="Type your message here..."
        ></textarea>
        <InputError class="mt-2" :message="form.errors.message" />
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="btn-primary inline-flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
      >
        <span v-if="form.processing">Sending...</span>
        <span v-else>Send Message</span>
      </button>
    </form>
  </div>
</template>
