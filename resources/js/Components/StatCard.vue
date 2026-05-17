<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  title: String,
  value: [String, Number],
  href: String,
  color: {
    type: String,
    default: 'gray',
  },
});

const theme = computed(() => {
  const colors = {
    gray:   { border: 'border-gray-700',   iconBg: 'bg-gray-700/50',   iconText: 'text-gray-300' },
    red:    { border: 'border-red-900',    iconBg: 'bg-red-900/30',    iconText: 'text-red-500' },
    yellow: { border: 'border-yellow-900', iconBg: 'bg-yellow-900/30', iconText: 'text-yellow-500' },
    green:  { border: 'border-green-900',  iconBg: 'bg-green-900/30',  iconText: 'text-green-500' },
    blue:   { border: 'border-blue-900',   iconBg: 'bg-blue-900/30',   iconText: 'text-blue-500' },
    indigo: { border: 'border-indigo-900', iconBg: 'bg-indigo-900/30', iconText: 'text-indigo-500' },
    purple: { border: 'border-purple-900', iconBg: 'bg-purple-900/30', iconText: 'text-purple-500' },
    pink:   { border: 'border-pink-900',   iconBg: 'bg-pink-900/30',   iconText: 'text-pink-500' },
    teal:   { border: 'border-teal-900',   iconBg: 'bg-teal-900/30',   iconText: 'text-teal-500' },
    orange: { border: 'border-orange-900', iconBg: 'bg-orange-900/30', iconText: 'text-orange-500' },
  };
  return colors[props.color] || colors.gray;
});
</script>

<template>
  <Link
    :href="href"
    class="bg-gray-800/40 backdrop-blur-sm border rounded-xl p-5 flex items-center space-x-4 shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800/60"
    :class="theme.border"
  >
    <div class="p-3 rounded-full flex-shrink-0" :class="[theme.iconBg, theme.iconText]">
      <slot />
    </div>
    <div>
      <p class="text-sm font-medium text-gray-400">{{ title }}</p>
      <p class="text-2xl font-bold text-white">{{ value }}</p>
    </div>
  </Link>
</template>