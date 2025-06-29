<template>
    <Head title="Welcome" />

    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-main selection:text-white" style="background-color: #FFF2E0;">

        <!-- Top-right Auth Buttons -->
        <div class="absolute top-6 right-6 space-x-4" v-if="canLogin">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm font-semibold text-main underline hover:text-white hover:bg-main transition rounded px-3 py-1"
                style="background-color: #FFF2E0;"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-sm font-semibold text-white bg-main underline hover:bg-support hover:text-white transition rounded px-4 py-2"
                    style="border: 2px solid #898AC4;"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm font-semibold text-main underline hover:text-white hover:bg-main transition rounded px-4 py-2"
                    style="border: 2px solid #898AC4; background-color: #FFF2E0;"
                >
                    Register
                </Link>
            </template>
        </div>

        <!-- Welcome Content -->
        <div class="text-center mt-12">
            <h1 class="text-5xl font-bold mb-4" style="color: #898AC4;">Welcome to Our Job Portal</h1>
            <p class="text-lg" style="color: #898AC4;">
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
