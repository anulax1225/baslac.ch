<script setup>
import Layout from '@/Layouts/Layout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <Layout>
        <template #header>
            <h2 class="text-lg font-semibold text-black py-2">
                Profile
            </h2>
        </template>
        <template #content>
            <div class="py-12">
                    <div class="mx-auto max-w-7xl space-y-6 laptop:px-6 desktop:px-8">
                        <div
                            class="bg-gray-50 p-4 shadow laptop:rounded-lg laptop:p-8"
                        >
                            <UpdateProfileInformationForm
                                :must-verify-email="mustVerifyEmail"
                                :status="status"
                                class="tablet:pr-64"
                            />
                        </div>

                        <div
                            class="bg-gray-50 p-4 shadow laptop:rounded-lg laptop:p-8"
                        >
                            <UpdatePasswordForm class="tablet:pr-64" />
                        </div>
                    </div>
                </div>
        </template>
    </Layout>
</template>
