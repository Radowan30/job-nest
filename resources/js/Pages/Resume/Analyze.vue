<!-- resources/js/Pages/Resume/Analyze.vue -->
<template>
  <div>
    <h1>Analyze Resume</h1>
    <button @click="runAnalysis">Run Analysis</button>
    <div v-if="matches.length">
      <h2>Job Matches:</h2>
      <ul>
        <li v-for="job in matches" :key="job.title">{{ job.title }} - Score: {{ job.score }}</li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const matches = ref([]);

const runAnalysis = async () => {
  const res = await axios.post('/api/analyze-resume');
  matches.value = res.data.matches;
};
</script>
