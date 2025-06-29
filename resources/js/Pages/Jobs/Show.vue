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
      <h2 class="text-xl font-semibold" style="color: #898AC4;">{{ job.title }}</h2>
    </template>

    <div class="py-10 px-4 max-w-2xl mx-auto" style="background-color: #FFF2E0; border-radius: 1rem;">
      <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-800 mb-4">{{ job.description }}</p>
        <p class="mt-2 text-gray-500">Company: <span style="color: #898AC4;">{{ job.company.name }}</span></p>

        <!-- Back to Jobs Button -->
        <div class="mt-6">
          <Link
            :href="route('jobs.index')"
            class="bg-main hover:bg-support text-white px-4 py-2 rounded font-semibold transition"
            style="border: 2px solid #898AC4;"
          >
            ← Back to Jobs
          </Link>
        </div>

        <!-- Applicant: apply -->
        <div v-if="auth.user.role === 'applicant'" class="mt-6">
          <button
            @click="apply"
            :disabled="applyForm.processing"
            class="bg-main hover:bg-support text-white px-6 py-2 rounded font-semibold transition"
            style="border: 2px solid #898AC4;"
          >
            {{ applyForm.processing ? 'Applying…' : 'Apply to this Job' }}
          </button>
        </div>

        <!-- Company: edit link -->
        <div v-if="auth.user.id === job.company_id" class="mt-6">
          <Link
            :href="route('jobs.edit', job.id)"
            class="text-main underline hover:text-white hover:bg-main transition rounded px-4 py-2"
            style="border: 2px solid #898AC4; background-color: #FFF2E0;"
          >
            Edit Job
          </Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
