<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {
  ArchiveBoxArrowDownIcon,
  CheckCircleIcon,
  CircleStackIcon,
  ExclamationTriangleIcon,
} from '@heroicons/vue/24/outline';

defineOptions({
  layout: AdminLayout,
});

const props = defineProps({
  availableYears: Array,
  beforeYear: Number,
  pendingByYear: Array,
  pendingTotal: Number,
  archivedByYear: Array,
  archivedTotal: Number,
  archivedForSelection: Number,
  archiveTotalForSelection: Number,
  batchSize: Number,
});

const page = usePage();
const confirmArchive = ref(false);
const isArchiving = ref(false);
const stopRequested = ref(false);
const statusMessage = ref('');
const errorMessage = ref('');
const pendingByYearState = ref(props.pendingByYear || []);
const pendingTotalState = ref(props.pendingTotal || 0);
const archivedByYearState = ref(props.archivedByYear || []);
const archivedTotalState = ref(props.archivedTotal || 0);
const archivedForSelectionState = ref(props.archivedForSelection || 0);
const archiveTotalForSelectionState = ref(props.archiveTotalForSelection || 0);
const lastBatch = ref(null);
const batchOptions = [1000, 2000, 5000, 10000];

const form = useForm({
  before_year: props.beforeYear,
  batch_size: props.batchSize,
});

const pendingRows = computed(() => pendingByYearState.value);
const archivedRows = computed(() => archivedByYearState.value);
const canArchive = computed(() => pendingTotalState.value > 0 && confirmArchive.value && !isArchiving.value);
const archiveDescription = computed(() => `Seasons before ${form.before_year} will be archived. Season ${form.before_year} and newer will stay active.`);
const progressPercent = computed(() => {
  if (!archiveTotalForSelectionState.value) return pendingTotalState.value === 0 ? 100 : 0;
  return Math.min(100, Math.round((archivedForSelectionState.value / archiveTotalForSelectionState.value) * 100));
});
const batchCaption = computed(() => {
  if (isArchiving.value) return `Archiving up to ${formatNumber(form.batch_size)} votes in the current batch...`;
  if (pendingTotalState.value === 0) return 'Archive is complete for this selection.';
  return `${formatNumber(pendingTotalState.value)} votes remain. Start archiving to process safe batches.`;
});

const formatNumber = (value) => Number(value || 0).toLocaleString();

const reloadForYear = () => {
  if (isArchiving.value) return;

  router.get(route('admin.votes.archive.index'), { before_year: form.before_year }, {
    preserveState: true,
    replace: true,
    showProgress: false,
  });
};

const applyStats = (stats) => {
  pendingByYearState.value = stats.pendingByYear || [];
  pendingTotalState.value = stats.pendingTotal || 0;
  archivedByYearState.value = stats.archivedByYear || [];
  archivedTotalState.value = stats.archivedTotal || 0;
  archivedForSelectionState.value = stats.archivedForSelection || 0;
  archiveTotalForSelectionState.value = stats.archiveTotalForSelection || 0;
};

const archiveOneBatch = async () => {
  const response = await window.axios.post(route('admin.votes.archive.store'), {
    before_year: form.before_year,
    batch_size: form.batch_size,
  }, {
    headers: { Accept: 'application/json' },
  });

  lastBatch.value = response.data.result;
  statusMessage.value = response.data.message;
  applyStats(response.data.stats);
};

const startArchiving = async () => {
  if (!canArchive.value) return;

  isArchiving.value = true;
  stopRequested.value = false;
  errorMessage.value = '';
  statusMessage.value = 'Archive started. Processing first batch...';

  try {
    while (!stopRequested.value && pendingTotalState.value > 0) {
      await archiveOneBatch();

      if (lastBatch.value?.selected === 0) {
        break;
      }

      await new Promise((resolve) => setTimeout(resolve, 350));
    }

    if (pendingTotalState.value === 0) {
      statusMessage.value = 'Archive complete for this selection.';
      confirmArchive.value = false;
    } else if (stopRequested.value) {
      statusMessage.value = 'Stopped after the current batch. You can resume anytime.';
    }
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Archive batch imeshindwa. Tafadhali jaribu tena au angalia laravel.log.';
  } finally {
    isArchiving.value = false;
  }
};

const stopArchiving = () => {
  stopRequested.value = true;
  statusMessage.value = 'Stopping after the current batch finishes...';
};
</script>

<template>
  <Head title="Vote Archives" />

  <div class="p-6 text-gray-100">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gold-gradient">Vote Archives</h1>
        <p class="mt-1 text-sm text-gray-400">
          Move older season votes out of the active voting table in controlled batches.
        </p>
      </div>
      <div class="inline-flex items-center rounded-md border border-gold-500/20 bg-gray-800/70 px-4 py-2 text-sm text-gold-200">
        <CircleStackIcon class="mr-2 h-5 w-5" />
        {{ formatNumber(archivedTotalState) }} archived votes
      </div>
    </div>

    <div v-if="page.props.flash?.success" class="mb-6 rounded-md border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
      {{ page.props.flash.success }}
    </div>

    <div v-if="page.props.flash?.error" class="mb-6 rounded-md border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
      {{ page.props.flash.error }}
    </div>

    <div v-if="statusMessage" class="mb-6 rounded-md border border-gold-500/30 bg-gold-500/10 px-4 py-3 text-sm text-gold-100">
      {{ statusMessage }}
    </div>

    <div v-if="errorMessage" class="mb-6 rounded-md border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
      {{ errorMessage }}
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
      <section class="xl:col-span-2 rounded-lg border border-gold-500/10 bg-gray-800/50 p-5 shadow-lg">
        <div class="flex items-start justify-between gap-4">
          <div>
            <h2 class="text-lg font-semibold text-white">Archive Active Votes</h2>
            <p class="mt-1 text-sm text-gray-400">
              Votes before the selected season will be copied to archive, then deleted only after the copy is confirmed.
            </p>
          </div>
          <ArchiveBoxArrowDownIcon class="h-8 w-8 flex-none text-gold-400" />
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
          <div>
            <label for="before_year" class="mb-1 block text-sm font-medium text-gray-400">Current active season</label>
            <select
              id="before_year"
              v-model="form.before_year"
              @change="reloadForYear"
              :disabled="isArchiving"
              class="w-full rounded-md border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500"
            >
              <option v-for="year in availableYears" :key="year" :value="year">{{ year }}</option>
            </select>
            <p class="mt-2 text-xs text-gray-500">{{ archiveDescription }}</p>
          </div>

          <div>
            <label for="batch_size" class="mb-1 block text-sm font-medium text-gray-400">Batch size</label>
            <input
              id="batch_size"
              v-model.number="form.batch_size"
              type="number"
              min="100"
              max="10000"
              step="100"
              :disabled="isArchiving"
              class="w-full rounded-md border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100 shadow-sm focus:border-gold-500 focus:ring-gold-500"
            />
            <div class="mt-2 flex flex-wrap gap-2">
              <button
                v-for="option in batchOptions"
                :key="option"
                type="button"
                :disabled="isArchiving"
                @click="form.batch_size = option"
                class="rounded border px-2 py-1 text-xs transition"
                :class="form.batch_size === option ? 'border-gold-500 bg-gold-500/15 text-gold-200' : 'border-gray-700 text-gray-400 hover:border-gray-500 hover:text-gray-200'"
              >
                {{ formatNumber(option) }}
              </button>
            </div>
          </div>

          <div class="rounded-md border border-gray-700 bg-gray-900/60 p-4">
            <div class="text-sm text-gray-400">Pending archive</div>
            <div class="mt-1 text-2xl font-bold text-gold-300">{{ formatNumber(pendingTotalState) }}</div>
          </div>
        </div>

        <div class="mt-6 rounded-md border border-gray-700 bg-gray-900/60 p-4">
          <div class="mb-2 flex items-center justify-between gap-3 text-sm">
            <span class="font-medium text-gray-300">Archive progress</span>
            <span class="font-mono text-gold-300">{{ progressPercent }}%</span>
          </div>
          <div class="h-3 overflow-hidden rounded-full bg-gray-700">
            <div
              class="h-full rounded-full bg-gold-500 transition-all duration-500"
              :class="{ 'progress-stripes': isArchiving }"
              :style="{ width: `${progressPercent}%` }"
            />
          </div>
          <div class="mt-3 grid grid-cols-1 gap-3 text-sm md:grid-cols-3">
            <div>
              <div class="text-gray-500">Archived for selection</div>
              <div class="font-mono font-semibold text-emerald-300">{{ formatNumber(archivedForSelectionState) }}</div>
            </div>
            <div>
              <div class="text-gray-500">Pending</div>
              <div class="font-mono font-semibold text-gold-300">{{ formatNumber(pendingTotalState) }}</div>
            </div>
            <div>
              <div class="text-gray-500">Total target</div>
              <div class="font-mono font-semibold text-gray-200">{{ formatNumber(archiveTotalForSelectionState) }}</div>
            </div>
          </div>
          <div v-if="lastBatch" class="mt-3 rounded-md border border-gray-700 bg-gray-950/40 px-3 py-2 text-xs text-gray-300">
            Last batch: selected {{ formatNumber(lastBatch.selected) }}, archived {{ formatNumber(lastBatch.archived) }}, deleted {{ formatNumber(lastBatch.deleted) }}.
          </div>
          <p class="mt-3 text-sm text-gray-400">{{ batchCaption }}</p>
        </div>

        <div class="mt-6 rounded-md border border-yellow-500/25 bg-yellow-500/10 p-4">
          <div class="flex gap-3">
            <ExclamationTriangleIcon class="mt-0.5 h-5 w-5 flex-none text-yellow-300" />
            <div class="text-sm text-yellow-100">
              To archive 2025 votes, choose 2026 as the current active season. This keeps 2026 votes active and moves 2025 and older votes.
            </div>
          </div>
        </div>

        <label class="mt-5 flex items-start gap-3 rounded-md border border-gray-700 bg-gray-900/50 p-4">
          <input
            v-model="confirmArchive"
            type="checkbox"
            :disabled="isArchiving"
            class="mt-1 rounded border-gray-600 bg-gray-900 text-gold-500 focus:ring-gold-500"
          />
          <span class="text-sm text-gray-300">
            I have backed up the database and I want to archive one batch of old votes.
          </span>
        </label>

        <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end">
          <button
            v-if="isArchiving"
            type="button"
            @click="stopArchiving"
            class="inline-flex items-center justify-center rounded-md border border-gray-600 px-4 py-2 text-sm font-bold text-gray-200 transition hover:bg-gray-700"
          >
            Stop After Batch
          </button>
          <button
            type="button"
            :disabled="!canArchive"
            @click="startArchiving"
            class="inline-flex items-center rounded-md bg-gold-500 px-4 py-2 text-sm font-bold text-gray-950 transition hover:bg-gold-400 disabled:cursor-not-allowed disabled:opacity-50"
          >
            <ArchiveBoxArrowDownIcon class="mr-2 h-5 w-5" :class="{ 'animate-pulse': isArchiving }" />
            {{ isArchiving ? 'Archiving...' : 'Start Archiving' }}
          </button>
        </div>
      </section>

      <section class="rounded-lg border border-gold-500/10 bg-gray-800/50 p-5 shadow-lg">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold text-white">Archived</h2>
          <CheckCircleIcon class="h-6 w-6 text-emerald-400" />
        </div>

        <div class="mt-4 space-y-3">
          <div v-if="archivedRows.length === 0" class="rounded-md border border-gray-700 bg-gray-900/50 p-4 text-sm text-gray-400">
            No archived votes yet.
          </div>
          <div
            v-for="row in archivedRows"
            :key="row.year"
            class="flex items-center justify-between rounded-md border border-gray-700 bg-gray-900/50 px-4 py-3"
          >
            <span class="text-sm text-gray-300">Season {{ row.year }}</span>
            <span class="font-mono text-sm font-semibold text-emerald-300">{{ formatNumber(row.total) }}</span>
          </div>
        </div>
      </section>
    </div>

    <section class="mt-6 rounded-lg border border-gold-500/10 bg-gray-800/50 p-5 shadow-lg">
      <h2 class="text-lg font-semibold text-white">Pending By Season</h2>
      <div class="mt-4 overflow-x-auto">
        <table class="w-full min-w-[420px] text-left text-sm text-gray-300">
          <thead class="bg-gray-700/50 text-xs uppercase text-gold-400">
            <tr>
              <th class="px-4 py-3">Season</th>
              <th class="px-4 py-3 text-right">Active Votes To Archive</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="pendingRows.length === 0">
              <td colspan="2" class="px-4 py-4 text-center text-gray-400">No old votes are pending archive.</td>
            </tr>
            <tr
              v-for="row in pendingRows"
              :key="row.year"
              class="border-b border-gray-700"
            >
              <td class="px-4 py-3 font-medium text-white">{{ row.year }}</td>
              <td class="px-4 py-3 text-right font-mono text-gold-300">{{ formatNumber(row.total) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</template>

<style scoped>
.text-gold-gradient {
  background: linear-gradient(to right, #D4AF37, #FFD700);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.progress-stripes {
  background-image: linear-gradient(
    45deg,
    rgba(255, 255, 255, 0.25) 25%,
    transparent 25%,
    transparent 50%,
    rgba(255, 255, 255, 0.25) 50%,
    rgba(255, 255, 255, 0.25) 75%,
    transparent 75%,
    transparent
  );
  background-size: 1rem 1rem;
  animation: progress-slide 0.8s linear infinite;
}

@keyframes progress-slide {
  from {
    background-position: 1rem 0;
  }
  to {
    background-position: 0 0;
  }
}
</style>
