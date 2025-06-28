<!-- resources/js/Pages/Resume/Upload.vue -->
<script setup>
import { reactive, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = reactive({ resume: null });
const filePath = ref('');
const auth = usePage().props.auth;

onMounted(async () => {
  try {
    const res = await axios.get('/api/resume');
    filePath.value = res.data.file_path;
  } catch (error) {
    console.error('Failed to fetch resume:', error);
  }
});

const submit = async () => {
  if (!form.resume) {
    alert('Please select a resume file');
    return;
  }

  const data = new FormData();
  data.append('resume', form.resume);

  try {
    const res = await axios.post('/api/resume', data);
    filePath.value = res.data.file_path;
  } catch (error) {
    alert('Upload failed.');
    console.error(error);
  }
};

const goAnalyze = () => {
  Inertia.visit('/resume/analyze');
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="max-w-xl mx-auto py-10">
      <h1 class="text-2xl font-bold mb-4">Upload Resume</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <input type="file" @change="e => form.resume = e.target.files[0]" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Upload</button>
      </form>

      <div v-if="filePath" class="mt-6 p-4 bg-gray-100 rounded">
        <p class="mb-2">Uploaded Resume: {{ filePath }}</p>
        <button @click="goAnalyze" class="bg-green-600 text-white px-4 py-2 rounded">Analyze Resume</button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
