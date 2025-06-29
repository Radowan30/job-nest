<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

// Mock data for demonstration; replace with real props/data as needed
const user = usePage().props.auth.user || { name: 'User' };
const jobs = usePage().props.jobs || [
    { id: 1, title: 'Frontend Developer', company: 'TechCorp' },
    { id: 2, title: 'Backend Developer', company: 'WebWorks' },
];
const applications = usePage().props.applications || [
    { id: 1, job: { title: 'Frontend Developer' }, status: 'Pending' },
    { id: 2, job: { title: 'Backend Developer' }, status: 'Accepted' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight" style="color: #898AC4;">
                Welcome, {{ user.name }}!
            </h2>
        </template>

        <div class="py-12" style="background-color: #FFF2E0;">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Jobs Preview -->
                <div class="bg-white rounded-lg shadow p-6 flex flex-col">
                    <h3 class="text-lg font-semibold mb-4" style="color: #898AC4;">Latest Jobs</h3>
                    <ul class="flex-1">
                        <li v-for="job in jobs" :key="job.id" class="mb-2">
                            <span class="font-medium">{{ job.title }}</span>
                            <span class="text-sm text-gray-500">({{ job.company }})</span>
                        </li>
                    </ul>
                    <Link
                        :href="route('jobs.index')"
                        class="mt-4 inline-block text-center bg-main text-white font-semibold px-4 py-2 rounded hover:bg-support transition"
                    >
                        View All Jobs
                    </Link>
                </div>

                <!-- Applications Preview (only for applicants) -->
                <div
                    v-if="user.role === 'applicant'"
                    class="bg-white rounded-lg shadow p-6 flex flex-col"
                >
                    <h3 class="text-lg font-semibold mb-4" style="color: #898AC4;">My Applications</h3>
                    <ul class="flex-1">
                        <li v-for="app in applications" :key="app.id" class="mb-2">
                            <span class="font-medium">{{ app.job.title }}</span>
                            <span class="ml-2 text-xs px-2 py-1 rounded" :style="{ backgroundColor: '#898AC4', color: '#FFF2E0' }">
                                {{ app.status }}
                            </span>
                        </li>
                        <li v-if="applications.length === 0" class="text-gray-400">No applications yet.</li>
                    </ul>
                    <Link
                        :href="route('applications.index')"
                        class="mt-4 inline-block text-center bg-main text-white font-semibold px-4 py-2 rounded hover:bg-support transition"
                    >
                        View My Applications
                    </Link>
                </div>

                <!-- Welcome/Info Section -->
                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center justify-center">
                    <h3 class="text-lg font-semibold mb-4" style="color: #898AC4;">Welcome to JobNest!</h3>
                    <p class="text-gray-700 text-center">
                        Explore new opportunities and manage your applications easily.
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
