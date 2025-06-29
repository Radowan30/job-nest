<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link, usePage } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

const user = usePage().props.auth.user
const logoutForm = useForm({})
const logout = () => logoutForm.post(route('logout'))
</script>

<template>
  <div class="min-h-screen text-gray-800 flex" style="background-color: #FFF2E0;">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
      <div class="p-4 border-b flex items-center justify-center">
        <Link :href="route('dashboard')">
          <img src="/logo.png" alt="JobNest Logo" class="h-24 w-24" />
        </Link>
      </div>
      <nav class="p-4 space-y-2">
        <Link
          :href="route('dashboard')"
          class="block rounded px-3 py-2 font-semibold text-main hover:bg-main hover:text-white transition"
        >Dashboard</Link>
        <Link
          :href="route('jobs.index')"
          class="block rounded px-3 py-2 font-semibold text-main hover:bg-main hover:text-white transition"
        >Jobs</Link>

        <template v-if="user?.role === 'company'">
          <Link
            :href="route('jobs.create')"
            class="block rounded px-3 py-2 font-semibold text-main hover:bg-main hover:text-white transition"
          >Create Job</Link>
        </template>

        <template v-if="user?.role === 'applicant'">
          <Link
            :href="route('applications.index')"
            class="block rounded px-3 py-2 font-semibold text-main hover:bg-main hover:text-white transition"
          >My Applications</Link>
          <Link
            :href="route('resume.upload')"
            class="block rounded px-3 py-2 font-semibold text-main hover:bg-main hover:text-white transition"
          >Upload Resume</Link>
          <Link
            :href="route('resume.analyze')"
            class="block rounded px-3 py-2 font-semibold text-main hover:bg-main hover:text-white transition"
          >Analyze Resume</Link>
        </template>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6" style="background-color: #FFF2E0;">
      <!-- Top Header -->
      <header class="mb-6 flex justify-between items-center border-b pb-4">
        <h1 class="text-2xl font-bold" style="color: #898AC4;">
          <slot name="header">Welcome</slot>
        </h1>
        <div class="text-sm text-gray-600 flex items-center gap-2">
          <span>
            Logged in as: <strong style="color: #898AC4;">{{ user.name }}</strong>
          </span>
          <form @submit.prevent="logout" class="inline ml-2">
            <button
              type="submit"
              class="text-red-500 hover:underline px-3 py-1 rounded transition"
              :disabled="logoutForm.processing"
              style="border: 2px solid #898AC4; background-color: #FFF2E0;"
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
