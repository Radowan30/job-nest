<!-- resources/js/Pages/Jobs/Show.vue -->
<template>
  <div>
    <h1>{{ job.title }}</h1>
    <p>{{ job.description }}</p>
    <p>Company: {{ job.company.name }}</p>

    <!-- Apply button for applicants -->
    <button v-if="auth.user?.role === 'applicant'" @click="apply">Apply</button>

    <!-- Edit/Delete for company owner -->
    <div v-if="auth.user?.id === job.company.id">
      <inertia-link :href="`/jobs/${job.id}/edit`">Edit Job</inertia-link>
      <button @click="deleteJob">Delete Job</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

const auth = usePage().props.value.auth;
const jobId = ref(usePage().props.value.jobId);
const job = ref({ company: {} });

onMounted(async () => {
  const res = await axios.get(`/api/jobs/${jobId.value}`);
  job.value = res.data;
});

// Apply to job
const apply = async () => {
  await axios.post('/api/applications', { job_id: jobId.value });
  alert('Applied!');
};

// Delete job (company)
const deleteJob = async () => {
  if (confirm('Delete this job?')) {
    await axios.delete(`/api/jobs/${jobId.value}`);
    Inertia.visit('/jobs');
  }
};
</script>
