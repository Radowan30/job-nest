<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link, usePage } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

const user = usePage().props.auth.user
const logoutForm = useForm({})
const logout = () => logoutForm.post(route('logout'))
</script>

<template>
  <div class="min-h-screen bg-gray-100 text-gray-800 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
      <div class="p-4 border-b">
        <Link :href="route('dashboard')">
          <ApplicationLogo class="h-10 w-10 text-gray-600" />
        </Link>
      </div>
      <nav class="p-4 space-y-2">
        <Link :href="route('dashboard')" class="block hover:text-indigo-600">Dashboard</Link>
        <Link :href="route('jobs.index')" class="block hover:text-indigo-600">Jobs</Link>

        <template v-if="user?.role === 'company'">
          <Link :href="route('jobs.create')" class="block hover:text-indigo-600">Create Job</Link>
        </template>

        <template v-if="user?.role === 'applicant'">
          <Link :href="route('applications.index')" class="block hover:text-indigo-600">My Applications</Link>
          <Link :href="route('resume.upload')" class="block hover:text-indigo-600">Upload Resume</Link>
          <Link :href="route('resume.analyze')" class="block hover:text-indigo-600">Analyze Resume</Link>
        </template>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <!-- Top Header -->
      <header class="mb-6 flex justify-between items-center border-b pb-4">
        <h1 class="text-2xl font-bold text-gray-700">
          <slot name="header">Welcome</slot>
        </h1>
        <div class="text-sm text-gray-600">
          Logged in as: <strong>{{ user.name }}</strong>
          <form @submit.prevent="logout" class="inline ml-2">
            <button
              type="submit"
              class="text-red-500 hover:underline"
              :disabled="logoutForm.processing"
            >
              <span v-if="logoutForm.processing">Logging out...</span>
              <span v-else>Logout</span>
            </button>
          </form>
        </div>
      </header>

      <!-- Page Content -->
      <section>
        <slot />
      </section>
    </main>
  </div>
</template>
