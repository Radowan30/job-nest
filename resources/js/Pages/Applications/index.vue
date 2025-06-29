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
      <h2 class="text-xl font-semibold" style="color: #898AC4;">
        {{ jobId ? `Applications for ${jobTitle}` : 'My Applications' }}
      </h2>
    </template>

    <div class="py-6 px-4 space-y-4" style="background-color: #FFF2E0; min-height: 80vh;">
      <!-- No applications -->
      <div v-if="applications.length === 0" class="text-gray-500 bg-white rounded shadow p-6">
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
        class="border border-main/30 bg-white p-6 rounded-lg shadow flex flex-col md:flex-row md:items-center md:justify-between"
      >
        <!-- Applicant view -->
        <div v-if="auth.user.role === 'applicant'">
          <p class="mb-1">
            <strong style="color: #898AC4;">Job:</strong>
            <span>{{ app.job.title }}</span>
          </p>
          <p>
            <strong style="color: #898AC4;">Status:</strong>
            <span
              class="ml-2 text-xs px-2 py-1 rounded"
              :style="{ backgroundColor: '#898AC4', color: '#FFF2E0' }"
            >
              {{ app.status }}
            </span>
          </p>
        </div>

        <!-- Company view -->
        <div v-else-if="auth.user.role === 'company'" class="w-full md:w-auto">
          <p class="mb-1">
            <strong style="color: #898AC4;">Applicant:</strong>
            <span>{{ app.user.name }}</span>
          </p>
          <p>
            <strong style="color: #898AC4;">Status:</strong>
            <span
              class="ml-2 text-xs px-2 py-1 rounded"
              :style="{ backgroundColor: '#898AC4', color: '#FFF2E0' }"
            >
              {{ app.status }}
            </span>
          </p>
          <div v-if="app.status === 'pending'" class="mt-2 space-x-2">
            <button
              @click="updateStatus(app.id, 'approved')"
              class="bg-main hover:bg-green-600 text-white px-4 py-2 rounded font-semibold transition"
              style="border: 2px solid #898AC4;"
            >
              Approve
            </button>
            <button
              @click="updateStatus(app.id, 'rejected')"
              class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold transition"
              style="border: 2px solid #898AC4;"
            >
              Reject
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
