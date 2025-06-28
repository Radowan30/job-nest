<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'

const { applications, auth, jobId, jobTitle } = usePage().props

function updateStatus(appId, status) {
  const form = useForm({ status })
  form.put(route('applications.update', appId))
}
</script>

<template>
  <Head title="Applications" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold">
        {{ jobId ? `Applications for ${jobTitle}` : 'My Applications' }}
      </h2>
    </template>

    <div class="py-6 px-4 space-y-4">
      <div v-for="app in applications" :key="app.id" class="border p-4 rounded">
        <div v-if="auth.user.role === 'applicant'">
          <p>Job: {{ app.job.title }}</p>
          <p>Status: {{ app.status }}</p>
        </div>

        <div v-else-if="auth.user.role === 'company'">
          <p>Applicant: {{ app.user.name }}</p>
          <p>Status: {{ app.status }}</p>
          <button
            v-if="app.status === 'pending'"
            @click="updateStatus(app.id, 'approved')"
            class="bg-green-500 text-white px-3 py-1 rounded mr-2"
          >Approve</button>
          <button
            v-if="app.status === 'pending'"
            @click="updateStatus(app.id, 'rejected')"
            class="bg-red-500 text-white px-3 py-1 rounded"
          >Reject</button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
