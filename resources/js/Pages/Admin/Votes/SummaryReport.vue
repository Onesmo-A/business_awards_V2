<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import debounce from 'lodash/debounce';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ExportIcon from '@/Components/Icons/ExportIcon.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
  summary: Array,
  filters: Object,
  categories: Array,
});

const search = ref(props.filters.search || '');
const categoryId = ref(props.filters.category_id || '');
const dateFrom = ref(props.filters.date_from || '');
const dateTo = ref(props.filters.date_to || '');

const activeFilters = computed(() => {
    const filters = {};
    if (search.value) filters.search = search.value;
    if (categoryId.value) filters.category_id = categoryId.value;
    if (dateFrom.value) filters.date_from = dateFrom.value;
    if (dateTo.value) filters.date_to = dateTo.value;
    return filters;
});

watch(activeFilters, debounce(() => {
  router.get(route('admin.votes.export.summary'), activeFilters.value, {
    preserveState: true,
    replace: true,
  });
}, 300));

const downloadUrl = computed(() => {
    const url = new URL(route('admin.votes.download.summary'));
    for (const key in activeFilters.value) {
        url.searchParams.append(key, activeFilters.value[key]);
    }
    return url.href;
});

const totalVotes = computed(() => {
    return props.summary.reduce((acc, item) => acc + item.votes_count, 0);
});
</script>

<template>
  <Head title="Vote Summary Report" />

  <div class="p-6 text-gray-100">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-white">Vote Summary Report</h1>
      <a :href="downloadUrl" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-bold rounded-lg transition text-sm">
        <ExportIcon class="mr-2" /> Download Summary PDF
      </a>
    </div>

    <!-- Filters -->
    <div class="mb-6 p-4 bg-gray-800/50 rounded-lg grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Search Nominee</label>
            <input type="text" v-model="search" placeholder="Search..." class="w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-900 text-gray-100" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Category</label>
            <select v-model="categoryId" class="w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-900 text-gray-100">
                <option value="">All Categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">From Date</label>
            <input type="date" v-model="dateFrom" class="w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-900 text-gray-100" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">To Date</label>
            <input type="date" v-model="dateTo" class="w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-900 text-gray-100" />
        </div>
    </div>

    <!-- Summary Table -->
    <div class="bg-gray-800/50 backdrop-blur-sm shadow-lg rounded-lg overflow-hidden">
      <table class="w-full text-sm text-left text-gray-300">
        <thead class="text-xs text-gray-400 uppercase bg-gray-700/50">
          <tr>
            <th class="px-4 py-3">Category</th>
            <th class="px-4 py-3">Nominee</th>
            <th class="px-4 py-3 text-right">Total Votes</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="summary.length === 0">
            <td colspan="3" class="px-4 py-4 text-center text-gray-400">No data found.</td>
          </tr>
          <tr v-for="(item, index) in summary" :key="index" class="border-b border-gray-700 hover:bg-gray-700/50">
            <td class="px-4 py-3 font-medium text-gray-400">{{ item.category }}</td>
            <td class="px-4 py-3 font-bold text-white">{{ item.nominee }}</td>
            <td class="px-4 py-3 text-right font-mono text-gold-400">{{ item.votes_count }}</td>
          </tr>
        </tbody>
        <tfoot class="bg-gray-700/80 font-bold text-white">
            <tr>
                <td colspan="2" class="px-4 py-3 text-right">GRAND TOTAL</td>
                <td class="px-4 py-3 text-right text-lg">{{ totalVotes }}</td>
            </tr>
        </tfoot>
      </table>
    </div>
  </div>
</template>

<style scoped>
.text-gold-400 { color: #fbbf24; }
</style>