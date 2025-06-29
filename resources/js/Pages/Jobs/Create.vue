<!-- resources/js/Pages/Jobs/Create.vue -->
<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Initialize the Inertia form with the fields your controller expects
const form = useForm({
    title: "",
    description: "",
});

async function submit() {
    try {
        // Send to Laravel first
        const response = await axios.post(route("jobs.store"), form.data());

        const jobId = response.data.job_id;

        // Send to external FastAPI RAG indexing endpoint
        const indexingResponse = await fetch(
            "https://fast-api-ai.vercel.app/indexing",
            {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    job_id: jobId,
                    job_title: form.title,
                    job_description: form.description,
                }),
            }
        );

        if (!indexingResponse.ok) {
            const errorData = await indexingResponse.json();
            alert(errorData.error || "Indexing failed");
            return;
        }

        // All good
        alert("Job uploaded successfully");
        form.reset("title", "description");
    } catch (error) {
        console.error(error);
        alert("Something went wrong.");
    }
}
</script>

<template>
    <Head title="Create Job" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight" style="color: #898AC4;">
                Create Job
            </h2>
        </template>

        <div class="py-12" style="background-color: #FFF2E0;">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <form
                    @submit.prevent="submit"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                >
                    <div class="mb-4">
                        <label
                            for="title"
                            class="block text-sm font-bold mb-2"
                            style="color: #898AC4;"
                        >
                            Title
                        </label>
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            required
                            class="shadow appearance-none border border-main rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-main"
                            placeholder="Job Title"
                            style="background-color: #FFF2E0;"
                        />
                        <div
                            v-if="form.errors.title"
                            class="text-red-600 text-sm mt-1"
                        >
                            {{ form.errors.title }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label
                            for="description"
                            class="block text-sm font-bold mb-2"
                            style="color: #898AC4;"
                        >
                            Description
                        </label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            class="shadow appearance-none border border-main rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-main"
                            placeholder="Job Description"
                            style="background-color: #FFF2E0;"
                        ></textarea>
                        <div
                            v-if="form.errors.description"
                            class="text-red-600 text-sm mt-1"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-main hover:bg-support text-white font-bold py-2 px-4 rounded transition"
                        style="border: 2px solid #898AC4;"
                    >
                        {{ form.processing ? "Saving…" : "Save" }}
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
