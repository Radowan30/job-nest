<script setup>
//! edit this lates
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" style="color: #898AC4;" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    style="background-color: #FFF2E0;"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" style="color: #898AC4;" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    style="background-color: #FFF2E0;"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" style="color: #898AC4;" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    style="background-color: #FFF2E0;"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                    style="color: #898AC4;"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    style="background-color: #FFF2E0;"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>
            
            <div class="mt-4">
                <InputLabel for="role" value="Role" style="color: #898AC4;" />

                <select
                    id="role"
                    v-model="form.role"
                    required
                    class="mt-1 block w-full rounded-md border-main shadow-sm focus:border-main focus:ring focus:ring-main focus:ring-opacity-50"
                    style="background-color: #FFF2E0; color: #898AC4;"
                >
                    <option disabled value="">Select Role</option>
                    <option value="applicant">Applicant</option>
                    <option value="company">Company</option>
                </select>

                <InputError class="mt-2" :message="form.errors.role" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-main underline hover:text-white hover:bg-main focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2 transition px-4 py-2"
                    style="border: 2px solid #898AC4; background-color: #FFF2E0;"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    style="background-color: #898AC4; border: 2px solid #898AC4;"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
