<!-- resources/js/Pages/Jobs/Create.vue -->
<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

// Initialize the Inertia form with the fields your controller expects
const form = useForm({
  title: '',
  description: '',
})

function submit() {
  // Post to the named route 'jobs.store'
  form.post(route('jobs.store'), {
    onSuccess: () => {
      // Optionally reset the form fields after successful creation
      form.reset('title', 'description')
    },
  })
}
</script>

<template>
  <Head title="Create Job" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight" style="color: #898AC4;">
        Create Job
      </h2>
    </template>

    <div class="py-12" style="background-color: #FFF2E0;">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
          <div class="mb-4">
            <label for="title" class="block text-sm font-bold mb-2" style="color: #898AC4;">
              Title
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              class="shadow appearance-none border border-main rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-main"
              placeholder="Job Title"
              style="background-color: #FFF2E0;"
            />
            <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">
              {{ form.errors.title }}
            </div>
          </div>

          <div class="mb-4">
            <label for="description" class="block text-sm font-bold mb-2" style="color: #898AC4;">
              Description
            </label>
            <textarea
              id="description"
              v-model="form.description"
              class="shadow appearance-none border border-main rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-main"
              placeholder="Job Description"
              style="background-color: #FFF2E0;"
            ></textarea>
            <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">
              {{ form.errors.description }}
            </div>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="bg-main hover:bg-support text-white font-bold py-2 px-4 rounded transition"
          >
            {{ form.processing ? 'Saving…' : 'Save' }}
          </button>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
