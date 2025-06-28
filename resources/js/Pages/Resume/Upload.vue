<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  filePath: String
})

// Initialize an Inertia form bound to the `resume` field
const form = useForm({
  resume: null,
})

// Handles the form submission via Inertia
function submit() {
  form.post(route('resume.upload.store'), {
    forceFormData: true,
    onSuccess: () => {
      // After upload, Inertia will return you to this page
      // with new props—no need to manually update filePath here.
    },
  })
}
</script>

<template>
  <Head title="Upload Resume" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">Upload Resume</h2>
    </template>

    <div class="py-12 max-w-4xl mx-auto">
      <form @submit.prevent="submit" enctype="multipart/form-data" class="mb-6">
        <input
          type="file"
          @change="e => form.resume = e.target.files[0]"
          required
        />
        <div v-if="form.errors.resume" class="text-red-600 text-sm mt-1">
          {{ form.errors.resume }}
        </div>
        <button
          :disabled="form.processing"
          class="ml-4 bg-blue-600 text-white px-4 py-1 rounded"
        >
          {{ form.processing ? 'Uploading…' : 'Upload' }}
        </button>
      </form>

      <div v-if="filePath" class="mt-4">
        <p class="text-gray-700">Uploaded resume: {{ filePath }}</p>
        <button
          @click="$inertia.visit(route('resume.analyze'))"
          class="mt-2 bg-green-600 text-white px-4 py-1 rounded"
        >
          Analyze Resume
        </button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
