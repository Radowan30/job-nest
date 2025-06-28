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
      <h2 class="text-xl font-semibold text-gray-800">Available Jobs</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
          <div v-for="job in jobs" :key="job.id" class="border-b pb-4 mb-4">
            <h3 class="text-lg font-semibold">{{ job.title }}</h3>
            <p class="text-sm text-gray-600">By {{ job.company?.name || 'Unknown' }}</p>
            <Link :href="`/jobs/${job.id}`" class="text-blue-500 hover:underline">View Details</Link>
          </div>

          <div v-if="auth?.user?.role === 'company'" class="mt-6">
            <Link href="/jobs/create" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
              Create New Job
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>