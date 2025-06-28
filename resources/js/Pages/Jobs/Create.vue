<!-- resources/js/Pages/Jobs/Create.vue -->
<template>
  <div>
    <h1>Create Job</h1>
    <form @submit.prevent="submit">
      <input v-model="form.title" placeholder="Title" />
      <textarea v-model="form.description" placeholder="Description"></textarea>
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

const form = reactive({ title: '', description: '' });
const submit = async () => {
  await axios.post('/api/jobs', form);
  Inertia.visit('/jobs');
};
</script>
