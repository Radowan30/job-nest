<!-- resources/js/Pages/Applications/Index.vue -->
<template>
  <div>
    <h1>My Applications</h1>
    <div v-if="auth.user.role === 'applicant'">
      <!-- Applicant's applications -->
      <div v-for="app in applications" :key="app.id">
        <p>Job: {{ app.job.title }} (Status: {{ app.status }})</p>
      </div>
    </div>
    <div v-if="jobId">
      <!-- Company viewing applications for job -->
      <h2>Applications for Job {{ jobId }}</h2>
      <div v-for="app in applications" :key="app.id">
        <p>Applicant: {{ app.user.name }} (Status: {{ app.status }})</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import axios from 'axios';

const auth = usePage().props.value.auth;
const jobId = usePage().props.value.jobId || null;
const applications = ref([]);

onMounted(async () => {
  if (auth.role === 'applicant') {
    const res = await axios.get('/api/applications');
    applications.value = res.data;
  } else if (jobId) {
    const res = await axios.get(`/api/jobs/${jobId}/applications`);
    applications.value = res.data;
  }
});
</script>
