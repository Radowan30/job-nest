<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, usePage, Link } from '@inertiajs/vue3'

const { job, auth } = usePage().props

const applyForm = useForm({ job_id: job.id })

function apply() {
  applyForm.post(route('applications.store'))
}
</script>

<template>
  <Head title="Job Details" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold">{{ job.title }}</h2>
    </template>

    <div class="py-6 px-4">
      <p>{{ job.description }}</p>
      <p class="mt-2 text-gray-500">Company: {{ job.company.name }}</p>

      <!-- Applicant: apply -->
      <div v-if="auth.user.role === 'applicant'" class="mt-4">
        <button
          @click="apply"
          :disabled="applyForm.processing"
          class="bg-green-500 text-white px-4 py-2 rounded"
        >
          {{ applyForm.processing ? 'Applying…' : 'Apply to this Job' }}
        </button>
      </div>

      <!-- Company: edit link -->
      <div v-if="auth.user.id === job.company_id" class="mt-4">
        <Link :href="route('jobs.edit', job.id)" class="text-blue-500">Edit Job</Link>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
