<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import Create from '@/Pages/Photo/Partials/Create.vue';
import Show from'@/Pages/Photo/Partials/Show.vue';
import Modal from '@/Pages/Photo/Partials/Modal.vue';
import { reactive, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    users: {
        type: Array,
    }
});   

let ids = []



const resetPassword = (id, email) => {
    if(!ids.includes(id)) {
        ids.push(id);
        axios.post(route('password.email') + "?email=" + email);
        document.querySelector("#reset-" + id).classList.remove("bg-primary");
        document.querySelector("#reset-" + id).classList.add("bg-gray-500");
        setTimeout(() => {
            ids = ids.filter(i => i != id);
            document.querySelector("#reset-" + id).classList.add("bg-primary");
            document.querySelector("#reset-" + id).classList.remove("bg-gray-500");
        }, 5 * 1000);
    }

}
</script>

<template>
    <Head title="Photos"/>
    <Layout>
        <template #header>
            <div class="w-full flex justify-between items-center py-1">
                <button class="bg-gray-300 p-2 py-1 rounded shadow text-gray-800 ml-1 laptop:text-lg text-sm">Utilisateurs</button>
                <Link :href="route('admin.user.create')" class="flex items-center hover:bg-black/10 rounded-md px-1 py-1">
                        <p class="font-medium laptop:mr-4 mr-1 laptop:text-lg text-sm">Ajouter un utilisateur</p>
                        <img src="/icons/add.svg" class="h-8">
                </Link>
            </div>
        </template>
        <template #content>
            <div class="laptop:w-full desktop:px-[17.5%] laptop:px-[12.5%]  overflow-x-auto px-2  h-screen">
                <div class="tablet:w-full flex flex-col mt-10 min-w-[850px]">
                    <div class="w-full grid p-4 border-b boder text-center laptop:text-lg text-sm font-medium"
                    style="grid-template-columns: repeat(15, minmax(0, 1fr));">
                        <p class="col-span-1"></p>
                        <p class="col-span-2">Nom</p>
                        <p class="col-span-2">Totem</p>
                        <p class="col-span-3">Email</p>
                        <p class="col-span-2">Tel.</p>
                        <p class="col-span-1">Contactable</p>
                        <p class="col-span-2">Créer le</p>
                        <p class="col-span-2">Mot de passe <p class="text-xs">(Renvoyer)</p></p>
                    </div>
                    <div v-for="(user, index) in users" class="w-full grid p-2 border-b laptop:text-md text-sm boder text-center items-center"
                    style="grid-template-columns: repeat(15, minmax(0, 1fr));">
                        <div class="w-10 rounded-full overflow-hidden col-span-1">
                            <img :src="user.pic" class="h-10">
                        </div>
                        <p class="col-span-2">{{ user.name }}</p>
                        <p class="col-span-2">{{ user.totem }}</p>
                        <p class="col-span-3">{{ user.email }}</p>
                        <p class="col-span-2">{{ user.tel }}</p>
                        <p class="col-span-1">{{ user.contactable ? "Oui" : "Non" }}</p>
                        <p class="col-span-2">{{ user.created_at }}</p>
                        <button :id="'reset-' + user.id" @click="resetPassword(user.id, user.email)" class="col-span-2 mx-auto bg-primary rounded pb-1 px-1 shadow shadow-gray-300"><img src="/icons/mail.svg" class="h-7 invert"></button>
                    </div>
                </div>
            </div>
        </template>
    </Layout>
</template>