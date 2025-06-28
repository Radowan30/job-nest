<!-- resources/js/Pages/Jobs/Edit.vue -->
<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Job</h2>
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

          <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Update</button>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, reactive, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

const jobId = ref(usePage().props.jobId);
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