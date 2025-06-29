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
      <h2 class="text-xl font-semibold leading-tight" style="color: #898AC4;">Edit Job</h2>
    </template>

    <div class="py-12" style="background-color: #FFF2E0;">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
          <div class="mb-4">
            <label class="block text-sm font-bold mb-2" style="color: #898AC4;">Title</label>
            <input
              v-model="form.title"
              class="shadow appearance-none border border-main rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-main"
              style="background-color: #FFF2E0;"
              required
            />
            <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">
              {{ form.errors.title }}
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-bold mb-2" style="color: #898AC4;">Description</label>
            <textarea
              v-model="form.description"
              class="shadow appearance-none border border-main rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-main"
              style="background-color: #FFF2E0;"
              required
            ></textarea>
            <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">
              {{ form.errors.description }}
            </div>
          </div>

          <button
            :disabled="form.processing"
            type="submit"
            class="bg-main hover:bg-support text-white font-bold py-2 px-4 rounded transition"
            style="border: 2px solid #898AC4;"
          >
            {{ form.processing ? 'Updating…' : 'Update Job' }}
          </button>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
