<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { ref } from "vue";

const props = defineProps({
    resumeText: String,
});

const form = useForm({
    resume_text: props.resumeText || "",
});

const recommendations = ref([]);
const analyzing = ref(false);

async function submit() {
    // Clean newlines + extra spaces
    form.resume_text = form.resume_text.replace(/\s+/g, " ");

    form.post(route("resume.upload.store"), {
        onSuccess: async () => {
            // Resume upload succeeded, now run AI analysis
            analyzing.value = true;

            const aiRes = await fetch(
                "https://fast-api-ai.vercel.app/job_recommendations",
                {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ message: form.resume_text }),
                }
            );

            const aiData = await aiRes.json();
            const recommendationList = aiData.recommendation_list || [];

            if (recommendationList.length === 0) {
                analyzing.value = false;
                alert("No recommendations received from AI.");
                return;
            }

            // Call your backend to get the job details
            const jobIds = recommendationList.map((r) => r.job_id).join(",");

            const jobsRes = await fetch(`/api/get-jobs?ids=${jobIds}`);
            const jobs = await jobsRes.json();

            // Combine info
            recommendations.value = recommendationList.map((r) => {
                const job = jobs.find((j) => j.id === r.job_id);
                return {
                    id: r.job_id,
                    title: job ? job.title : "Job Not Found",
                    description: job
                        ? job.description
                        : "No description available.",
                    why_good_fit: r.why_good_fit,
                };
            });

            analyzing.value = false;
        },
        onError: () => {
            alert("Failed to upload resume.");
        },
    });
}
</script>

<template>
    <Head title="Upload Resume" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold" style="color: #898AC4;">Upload Resume</h2>
        </template>

        <div class="py-12 max-w-4xl mx-auto" style="background-color: #FFF2E0;">
            <form @submit.prevent="submit" class="mb-6 bg-white shadow-md rounded px-8 pt-6 pb-8">
                <textarea
                    v-model="form.resume_text"
                    rows="10"
                    placeholder="Paste your resume text here..."
                    required
                    class="w-full border border-main p-4 rounded focus:ring-main focus:border-main"
                    style="background-color: #FFF2E0; color: #898AC4;"
                ></textarea>

                <InputError
                    v-if="form.errors.resume_text"
                    :message="form.errors.resume_text"
                    class="text-red-600 mt-1"
                />

                <button
                    :disabled="form.processing || analyzing"
                    class="ml-4 bg-main hover:bg-support text-white px-6 py-2 rounded font-semibold transition mt-4"
                    style="border: 2px solid #898AC4;"
                >
                    {{
                        form.processing || analyzing
                            ? "Uploading & Analyzing…"
                            : "Upload & Analyze"
                    }}
                </button>
            </form>

            <div v-if="recommendations.length" class="mt-8">
                <h3 class="text-lg font-bold mb-4" style="color: #898AC4;">Job Recommendations:</h3>

                <div
                    v-for="(rec, index) in recommendations"
                    :key="rec.id"
                    class="mb-6 p-6 border border-main rounded-lg bg-white shadow"
                >
                    <h4 class="font-bold mb-2" style="color: #898AC4;">Job {{ index + 1 }}</h4>

                    <p class="mb-1">
                        <span class="font-semibold" style="color: #898AC4;">Job Title:</span>
                        {{ rec.title || "Job Not Found" }}
                    </p>

                    <p class="mb-2">
                        <span class="font-semibold" style="color: #898AC4;">Job Description:</span>
                        {{ rec.description || "No description available." }}
                    </p>

                    <p class="mt-2">
                        <span class="font-semibold" style="color: #34D399;">Why You’re a Good Fit:</span>
                        {{ rec.why_good_fit }}
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
