<template>
    <Head title="Welcome" />

    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center selection:bg-red-500 selection:text-white">

        <!-- Top-right Auth Buttons -->
        <div class="absolute top-6 right-6 space-x-4" v-if="canLogin">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 dark:text-gray-500 underline"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-sm text-white dark:text-gray-500 underline"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                >
                    Register
                </Link>
            </template>
        </div>

        <!-- Welcome Content -->
        <div class="text-center">
            <h1 class="text-5xl font-bold text-gray-800 dark:text-white mb-4">Welcome to Our Job Portal</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Helping companies and applicants connect with ease.
            </p>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    canLogin: {
        type: Boolean,
        default: true
    },
    canRegister: {
        type: Boolean,
        default: true
    },
})
</script>
