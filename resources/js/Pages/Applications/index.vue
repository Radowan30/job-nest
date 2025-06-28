<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'

const props = usePage().props
const { applications, auth, jobId, jobTitle } = props

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
      <!-- No applications -->
      <div v-if="applications.length === 0" class="text-gray-500">
        <p v-if="auth.user.role === 'applicant'">
          You haven’t applied to any jobs yet.
        </p>
        <p v-else>
          There are no applications for this job yet.
        </p>
      </div>

      <!-- List of applications -->
      <div
        v-else
        v-for="app in applications"
        :key="app.id"
        class="border p-4 rounded"
      >
        <!-- Applicant view -->
        <div v-if="auth.user.role === 'applicant'">
          <p><strong>Job:</strong> {{ app.job.title }}</p>
          <p><strong>Status:</strong> {{ app.status }}</p>
        </div>

        <!-- Company view -->
        <div v-else-if="auth.user.role === 'company'">
          <p><strong>Applicant:</strong> {{ app.user.name }}</p>
          <p><strong>Status:</strong> {{ app.status }}</p>
          <div v-if="app.status === 'pending'" class="mt-2 space-x-2">
            <button
              @click="updateStatus(app.id, 'approved')"
              class="bg-green-500 text-white px-3 py-1 rounded"
            >
              Approve
            </button>
            <button
              @click="updateStatus(app.id, 'rejected')"
              class="bg-red-500 text-white px-3 py-1 rounded"
            >
              Reject
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
