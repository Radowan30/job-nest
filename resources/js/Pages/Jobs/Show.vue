<!-- resources/js/Pages/Jobs/Show.vue -->
<script setup>
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  job: Object, // comes from the backend controller
});

const auth = usePage().props.auth;

// Apply to job
const apply = async () => {
  try {
    await axios.post('/api/applications', { job_id: props.job.id });
    alert('Applied!');
  } catch (error) {
    alert('Error applying to job.');
  }
};

// Delete job (company)
const deleteJob = async () => {
  if (confirm('Delete this job?')) {
    try {
      await axios.delete(`/api/jobs/${props.job.id}`);
      Inertia.visit('/jobs');
    } catch (error) {
      alert('Failed to delete job.');
    }
  }
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto py-10">
      <h1 class="text-2xl font-bold mb-2">{{ job.title }}</h1>
      <p class="mb-4">{{ job.description }}</p>
      <p class="mb-6 text-sm text-gray-600">Posted by: {{ job.company.name }}</p>

      <!-- Apply button for applicants -->
      <div v-if="auth.user?.role === 'applicant'" class="mb-4">
        <button @click="apply" class="px-4 py-2 bg-blue-600 text-white rounded">Apply</button>
      </div>

      <!-- Edit/Delete for company owner -->
      <div v-if="auth.user?.id === job.company.id" class="space-x-4">
        <Link :href="`/jobs/${job.id}/edit`" class="text-blue-600 underline">Edit Job</Link>
        <button @click="deleteJob" class="text-red-600 underline">Delete Job</button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
