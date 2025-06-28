<script setup>
import { ref, reactive } from 'vue'
import { Head } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  filePath: String
})

const form = reactive({ resume: null })
const filePath = ref(props.filePath)

const submit = async () => {
  const data = new FormData()
  data.append('resume', form.resume)

  try {
    const response = await fetch('/api/resume', {
      method: 'POST',
      body: data
    })

    const result = await response.json()
    filePath.value = result.file_path
  } catch (error) {
    console.error('Resume upload failed:', error)
  }
}

const goAnalyze = () => {
  Inertia.visit('/resume/analyze')
}
</script>

<template>
  <Head title="Upload Resume" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">Upload Resume</h2>
    </template>

    <div class="py-12 max-w-4xl mx-auto">
      <form @submit.prevent="submit" class="mb-6">
        <input type="file" @change="e => form.resume = e.target.files[0]" />
        <button type="submit" class="ml-4 bg-blue-600 text-white px-4 py-1 rounded">Upload</button>
      </form>

      <div v-if="filePath">
        <p class="text-gray-700">Uploaded resume: {{ filePath }}</p>
        <button @click="goAnalyze" class="mt-2 bg-green-600 text-white px-4 py-1 rounded">Analyze Resume</button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
