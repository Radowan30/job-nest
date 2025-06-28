<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const matches = ref([])

const runAnalysis = async () => {
  try {
    const res = await fetch('/api/analyze-resume', { method: 'POST' })
    const data = await res.json()
    matches.value = data.matches
  } catch (err) {
    console.error('Analysis failed:', err)
  }
}
</script>

<template>
  <Head title="Analyze Resume" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">Analyze Resume</h2>
    </template>

    <div class="py-12 max-w-3xl mx-auto">
      <button @click="runAnalysis" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">Run Analysis</button>
      <div v-if="matches.length">
        <h3 class="text-lg font-bold mb-2">Job Matches:</h3>
        <ul class="list-disc ml-5">
          <li v-for="job in matches" :key="job.title">{{ job.title }} - Score: {{ job.score }}</li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
