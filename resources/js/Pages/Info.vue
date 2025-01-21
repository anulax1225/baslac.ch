<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
</script>

<template>
    <Head title="Home"/>
    <Layout>
        <template #content>
            <div class="w-full h-screen flex items-center justify-center px-[13.5%] py-[10%]">
                <MarkdownEditor/>
            </div>
        </template>
    </Layout>
</template>