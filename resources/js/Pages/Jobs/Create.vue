<!-- resources/js/Pages/Jobs/Create.vue -->
<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Create Job</h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input v-model="form.title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Job Title" />
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea v-model="form.description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Job Description"></textarea>
          </div>

          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

const form = reactive({ title: '', description: '' });
const submit = async () => {
  await axios.post('/api/jobs', form);
  Inertia.visit('/jobs');
};
</script>
