<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = usePage().props.value;
const auth = props.auth;
const jobId = props.jobId || null;

const applications = ref([]);
const error = ref(null);
const loading = ref(true);

onMounted(async () => {
  try {
    if (auth.user.role === 'applicant') {
      const res = await axios.get('/api/applications');
      applications.value = res.data;
    } else if (auth.user.role === 'company' && jobId) {
      const res = await axios.get(`/api/jobs/${jobId}/applications`);
      applications.value = res.data;
    }
  } catch (err) {
    error.value = 'Could not load applications.';
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto py-10">
      <h1 class="text-2xl font-bold mb-4">Applications</h1>

      <div v-if="loading">Loading...</div>
      <div v-else-if="error" class="text-red-600">{{ error }}</div>
      <div v-else>
        <!-- Applicant view -->
        <div v-if="auth.user.role === 'applicant'">
          <div v-if="applications.length">
            <div v-for="app in applications" :key="app.id" class="mb-4 p-4 border rounded">
              <p class="font-semibold">Job: {{ app.job.title }}</p>
              <p>Status: {{ app.status }}</p>
            </div>
          </div>
          <p v-else>No applications found.</p>
        </div>

        <!-- Company view -->
        <div v-if="auth.user.role === 'company' && jobId">
          <h2 class="text-xl font-semibold mb-2">Applications for Job ID: {{ jobId }}</h2>
          <div v-if="applications.length">
            <div v-for="app in applications" :key="app.id" class="mb-4 p-4 border rounded">
              <p class="font-semibold">Applicant: {{ app.user.name }}</p>
              <p>Status: {{ app.status }}</p>
            </div>
          </div>
          <p v-else>No applications found for this job.</p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
