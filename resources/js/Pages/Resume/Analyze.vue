<!-- resources/js/Pages/Resume/Analyze.vue -->
<script setup>
import { ref } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const matches = ref([]);
const loading = ref(false);
const error = ref(null);

const runAnalysis = async () => {
  loading.value = true;
  error.value = null;

  try {
    const res = await axios.post('/api/analyze-resume');
    matches.value = res.data.matches || [];
  } catch (err) {
    error.value = 'Failed to analyze resume.';
    console.error(err);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="max-w-3xl mx-auto py-10">
      <h1 class="text-2xl font-bold mb-4">Analyze Resume</h1>

      <button
        @click="runAnalysis"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        :disabled="loading"
      >
        {{ loading ? 'Analyzing...' : 'Run Analysis' }}
      </button>

      <div v-if="error" class="mt-4 text-red-600">
        {{ error }}
      </div>

      <div v-if="matches.length" class="mt-6">
        <h2 class="text-xl font-semibold mb-2">Job Matches:</h2>
        <ul class="list-disc list-inside space-y-1">
          <li v-for="job in matches" :key="job.title">
            {{ job.title }} – Score: {{ job.score }}
          </li>
        </ul>
      </div>

      <div v-else-if="!loading" class="mt-4 text-gray-500">
        No matches found yet. Click "Run Analysis" to begin.
      </div>
    </div>
  </AuthenticatedLayout>
</template>
