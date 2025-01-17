<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
</script>

<template>
    <Head title="Home"/>
    <GuestLayout>
        <template #content>
            <div class="w-full h-screen flex items-center justify-center px-[13.5%] py-[10%]">
                <MarkdownEditor/>
            </div>
        </template>
    </GuestLayout>
</template>