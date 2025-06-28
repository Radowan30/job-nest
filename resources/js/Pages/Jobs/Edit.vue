<!-- resources/js/Pages/Jobs/Edit.vue -->
<template>
  <div>
    <h1>Edit Job</h1>
    <form @submit.prevent="submit">
      <input v-model="form.title" placeholder="Title" />
      <textarea v-model="form.description" placeholder="Description"></textarea>
      <button type="submit">Update</button>
    </form>
  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

const jobId = ref(usePage().props.value.jobId);
const form = reactive({ title: '', description: '' });

onMounted(async () => {
  const res = await axios.get(`/api/jobs/${jobId.value}`);
  Object.assign(form, res.data);
});

const submit = async () => {
  await axios.put(`/api/jobs/${jobId.value}`, form);
  Inertia.visit(`/jobs/${jobId.value}`);
};
</script>
