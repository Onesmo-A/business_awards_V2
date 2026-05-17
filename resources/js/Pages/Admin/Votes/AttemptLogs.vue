<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { computed, ref, watch } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
  logs: Object,
  filters: Object,
  categories: Array,
  statuses: Array,
  reasons: Array,
  stats: Object,
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');
const reason = ref(props.filters.reason || '');
const categoryId = ref(props.filters.category_id || '');
const dateFrom = ref(props.filters.date_from || '');
const dateTo = ref(props.filters.date_to || '');

const activeFilters = computed(() => {
  const filters = {};
  if (search.value) filters.search = search.value;
  if (status.value) filters.status = status.value;
  if (reason.value) filters.reason = reason.value;
  if (categoryId.value) filters.category_id = categoryId.value;
  if (dateFrom.value) filters.date_from = dateFrom.value;
  if (dateTo.value) filters.date_to = dateTo.value;
  return filters;
});

watch(activeFilters, debounce(() => {
  router.get(route('admin.votes.attempt-logs.index'), activeFilters.value, {
    preserveState: true,
    replace: true,
  });
}, 300));

const clearFilters = () => {
  search.value = '';
  status.value = '';
  reason.value = '';
  categoryId.value = '';
  dateFrom.value = '';
  dateTo.value = '';
};

const formatDate = (datetime) => {
  if (!datetime) return 'N/A';

  return new Date(datetime).toLocaleString('en-GB', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

const shortHash = (value) => value ? `${value.slice(0, 10)}...` : 'N/A';

const statusClass = (value) => ({
  success: 'bg-green-500/15 text-green-300 border-green-500/30',
  duplicate: 'bg-yellow-500/15 text-yellow-300 border-yellow-500/30',
  blocked: 'bg-orange-500/15 text-orange-300 border-orange-500/30',
  failed: 'bg-red-500/15 text-red-300 border-red-500/30',
}[value] || 'bg-gray-500/15 text-gray-300 border-gray-500/30');
</script>

<template>
  <Head title="Vote Attempt Logs" />

  <div class="p-6 text-gray-100">
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gold-gradient">Vote Attempt Logs</h1>
        <p class="mt-1 text-sm text-gray-400">Trace accepted, blocked, duplicate, and failed vote attempts.</p>
      </div>
      <Link :href="route('admin.votes.index')" class="inline-flex items-center justify-center rounded-lg bg-gray-700 px-4 py-2 text-sm font-bold text-white transition hover:bg-gray-600">
        View Votes
      </Link>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <div class="rounded-lg border border-gray-700 bg-gray-800/50 p-4">
        <div class="text-sm text-gray-400">Attempts Today</div>
        <div class="mt-1 text-2xl font-bold text-white">{{ stats.today }}</div>
      </div>
      <div class="rounded-lg border border-green-500/20 bg-green-500/10 p-4">
        <div class="text-sm text-green-200">Success</div>
        <div class="mt-1 text-2xl font-bold text-green-100">{{ stats.success_today }}</div>
      </div>
      <div class="rounded-lg border border-yellow-500/20 bg-yellow-500/10 p-4">
        <div class="text-sm text-yellow-200">Duplicates</div>
        <div class="mt-1 text-2xl font-bold text-yellow-100">{{ stats.duplicates_today }}</div>
      </div>
      <div class="rounded-lg border border-red-500/20 bg-red-500/10 p-4">
        <div class="text-sm text-red-200">Failed</div>
        <div class="mt-1 text-2xl font-bold text-red-100">{{ stats.failed_today }}</div>
      </div>
    </div>

    <div class="mb-6 rounded-lg bg-gray-800/50 p-4">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-6">
        <div class="lg:col-span-2">
          <label for="search" class="mb-1 block text-sm font-medium text-gray-400">Search</label>
          <input id="search" v-model="search" type="text" placeholder="Nominee, IP, request ID, message..." class="w-full rounded-md border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500" />
        </div>
        <div>
          <label for="status" class="mb-1 block text-sm font-medium text-gray-400">Status</label>
          <select id="status" v-model="status" class="w-full rounded-md border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500">
            <option value="">All</option>
            <option v-for="item in statuses" :key="item" :value="item">{{ item }}</option>
          </select>
        </div>
        <div>
          <label for="reason" class="mb-1 block text-sm font-medium text-gray-400">Reason</label>
          <select id="reason" v-model="reason" class="w-full rounded-md border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500">
            <option value="">All</option>
            <option v-for="item in reasons" :key="item" :value="item">{{ item }}</option>
          </select>
        </div>
        <div>
          <label for="category" class="mb-1 block text-sm font-medium text-gray-400">Category</label>
          <select id="category" v-model="categoryId" class="w-full rounded-md border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500">
            <option value="">All</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select>
        </div>
        <div>
          <label for="date_from" class="mb-1 block text-sm font-medium text-gray-400">From</label>
          <input id="date_from" v-model="dateFrom" type="date" class="w-full rounded-md border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500" />
        </div>
        <div>
          <label for="date_to" class="mb-1 block text-sm font-medium text-gray-400">To</label>
          <input id="date_to" v-model="dateTo" type="date" class="w-full rounded-md border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500" />
        </div>
      </div>
      <div class="mt-4 flex justify-end">
        <button @click="clearFilters" class="rounded-lg bg-gray-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-gray-700">Clear Filters</button>
      </div>
    </div>

    <div class="overflow-hidden overflow-x-auto rounded-lg bg-gray-800/50 shadow-lg">
      <table class="w-full min-w-[1100px] text-left text-sm text-gray-300">
        <thead class="bg-gray-700/50 text-xs uppercase text-gold-400">
          <tr>
            <th class="px-4 py-3">Time</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Reason</th>
            <th class="px-4 py-3">Nominee</th>
            <th class="px-4 py-3">Category</th>
            <th class="px-4 py-3">IP</th>
            <th class="px-4 py-3">Browser Token</th>
            <th class="px-4 py-3">Fingerprint</th>
            <th class="px-4 py-3">Message</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="logs.data.length === 0">
            <td colspan="9" class="px-4 py-5 text-center text-gray-400">No attempt logs found.</td>
          </tr>
          <tr v-for="log in logs.data" :key="log.id" class="border-b border-gray-700 transition hover:bg-gray-700/50">
            <td class="px-4 py-3 text-gray-400">{{ formatDate(log.created_at) }}</td>
            <td class="px-4 py-3">
              <span class="rounded-full border px-2 py-1 text-xs font-semibold" :class="statusClass(log.status)">{{ log.status }}</span>
            </td>
            <td class="px-4 py-3 text-gray-300">{{ log.reason || 'N/A' }}</td>
            <td class="px-4 py-3 text-white">{{ log.nominee?.name || 'N/A' }}</td>
            <td class="px-4 py-3 text-gray-400">{{ log.category?.name || 'N/A' }}</td>
            <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ log.ip_address || 'N/A' }}</td>
            <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ shortHash(log.browser_token_hash) }}</td>
            <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ shortHash(log.fingerprint_js_hash) }}</td>
            <td class="px-4 py-3 text-gray-400">{{ log.message || 'N/A' }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="logs.links.length > 3" class="mt-6 flex justify-center">
      <div class="flex flex-wrap">
        <template v-for="(link, key) in logs.links" :key="key">
          <div v-if="link.url === null" class="mb-1 mr-1 rounded-md border border-gray-700 px-4 py-3 text-sm leading-4 text-gray-500" v-html="link.label" />
          <Link v-else class="mb-1 mr-1 rounded-md border border-gray-700 px-4 py-3 text-sm leading-4 transition hover:bg-gray-700 focus:border-gold-500 focus:text-gold-500" :class="{ 'bg-gold-500 font-bold text-gray-900': link.active }" :href="link.url" v-html="link.label" />
        </template>
      </div>
    </div>
  </div>
</template>

<style scoped>
.text-gold-gradient {
  background: linear-gradient(to right, #D4AF37, #FFD700);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
</style>
