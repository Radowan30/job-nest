<script setup>
import { usePage, Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({ jobs: Array })
const auth = usePage().props.auth
</script>

<template>
  <Head title="Jobs" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold" style="color: #898AC4;">Available Jobs</h2>
    </template>

    <div class="py-12" style="background-color: #FFF2E0;">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
          <div
            v-for="job in jobs"
            :key="job.id"
            class="border-b border-main/30 pb-4 mb-4"
          >
            <h3 class="text-lg font-semibold" style="color: #898AC4;">{{ job.title }}</h3>
            <p class="text-sm text-gray-600">
              By <span style="color: #898AC4;">{{ job.company?.name || 'Unknown' }}</span>
            </p>
            <Link
              :href="`/jobs/${job.id}`"
              class="inline-block mt-2 px-4 py-2 bg-main text-white rounded hover:bg-support font-semibold transition"
              style="border: 2px solid #898AC4;"
            >
              View Details
            </Link>
          </div>

          <div v-if="auth?.user?.role === 'company'" class="mt-6">
            <Link
              href="/jobs/create"
              class="inline-block px-4 py-2 bg-main text-white rounded hover:bg-support font-semibold transition"
              style="border: 2px solid #898AC4;"
            >
              Create New Job
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>