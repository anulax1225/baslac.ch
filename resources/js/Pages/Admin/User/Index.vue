<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import Create from '@/Pages/Photo/Partials/Create.vue';
import Show from'@/Pages/Photo/Partials/Show.vue';
import Modal from '@/Pages/Photo/Partials/Modal.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    users: {
        type: Array,
    }
});   
</script>

<template>
    <Head title="Photos"/>
    <Layout>
        <template #header>
            <div class="w-full flex justify-between items-center py-1">
                <button class="bg-gray-300 p-2 py-1 rounded shadow text-gray-800">Utilisateurs</button>
                <Link :href="route('admin.user.create')" class="flex items-center hover:bg-black/10 rounded-md px-2 py-1">
                        <p class="font-medium mr-4">Ajouter une photo</p>
                        <img src="/icons/add.svg" class="h-8">
                </Link>
            </div>
        </template>
        <template #content>
            <div class="w-full px-[17.5%] h-screen">
                <div class="w-full flex flex-col mt-10">
                    <div class="w-full grid grid-cols-6 p-4 border-b boder text-center text-lg font-medium">
                        <p>Nom</p>
                        <p>Totem</p>
                        <p>Email</p>
                        <p>Tel.</p>
                        <p>Contactable</p>
                        <p>Créer le</p>
                    </div>
                    <div v-for="(user, index) in users" class="w-full grid grid-cols-6 p-4 border-b boder text-center">
                        <p>{{ user.name }}</p>
                        <p>{{ user.totem }}</p>
                        <p>{{ user.email }}</p>
                        <p>{{ user.tel }}</p>
                        <p>{{ user.contactable ? "Oui" : "Non" }}</p>
                        <p>{{ user.created_at }}</p>
                    </div>
                </div>
            </div>
        </template>
    </Layout>
</template>