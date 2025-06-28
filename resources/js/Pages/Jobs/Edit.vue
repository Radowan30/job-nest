<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({ job: Object });

const form = useForm({
  title: job.title,
  description: job.description,
});

const submit = () => {
  form.put(route('jobs.update', job.id));
};
</script>

<template>
  <Head title="Edit Job" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">Edit Job</h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input v-model="form.title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" />
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea v-model="form.description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
          </div>

          <button :disabled="form.processing" type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Update Job
          </button>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
