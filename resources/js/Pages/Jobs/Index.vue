<!-- resources/js/Pages/Jobs/Index.vue -->
<template>
  <div>
    <h1>Available Jobs</h1>
    <div v-for="job in jobs" :key="job.id" class="border p-2 my-2">
      <h3>{{ job.title }}</h3>
      <p>By {{ job.company.name }}</p>
      <inertia-link :href="`/jobs/${job.id}`">View Details</inertia-link>
    </div>
    <inertia-link v-if="auth.user?.role === 'company'" href="/jobs/create">Create New Job</inertia-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { InertiaLink } from '@inertiajs/inertia-vue3';
import axios from 'axios';

const auth = usePage().props.value.auth;  // shared user
const jobs = ref([]);

onMounted(async () => {
  const res = await axios.get('/api/jobs');
  jobs.value = res.data;
});
</script>
