<!-- resources/js/Pages/Resume/Upload.vue -->
<template>
  <div>
    <h1>Upload Resume</h1>
    <form @submit.prevent="submit">
      <input type="file" @change="e => form.resume = e.target.files[0]" />
      <button type="submit">Upload</button>
    </form>
    <div v-if="filePath">
      <p>Uploaded resume: {{ filePath }}</p>
      <button @click="goAnalyze">Analyze Resume</button>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';
import axios from 'axios';

const form = reactive({ resume: null });
const filePath = ref('');
const user = usePage().props.value.auth.user;

onMounted(async () => {
  const res = await axios.get('/api/resume');
  filePath.value = res.data.file_path;
});

const submit = async () => {
  const data = new FormData();
  data.append('resume', form.resume);
  const res = await axios.post('/api/resume', data);
  filePath.value = res.data.file_path;
};

const goAnalyze = () => {
  Inertia.visit('/resume/analyze');
};
</script>
