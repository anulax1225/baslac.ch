<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';  
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: "",
    email: "",
    totem: "",
});

const submit = () => {
    form.post("/admin/user", {
        headers: {
            "X-CSRF-Token": document.querySelector('input[name=_token]').value,
        },
    })
}

</script>

<template>
    <Head title="Nouvelle utilisateur"/>
    <Layout>
        <template #header>
            <div class="w-full flex justify-between items-center py-1">
                <button class="bg-gray-300 p-2 py-1 rounded shadow text-gray-800">
                    {{ route().current('admin.user.create') ? "Nouvelle utilisateur" : "Utilisateurs" }}
                    </button>
                <Link :href="route().current('admin.user.create') ? route('admin.user.index') : route('admin.user.create')" class="flex items-center hover:bg-black/10 rounded-md px-2 py-1">
                        <p class="font-medium mr-4 py-1">Revenir a la list</p>
                        <img v-if="!route().current('admin.user.create')" src="/icons/add.svg" class="h-8">
                </Link>
            </div>
        </template>
        <template #content>
            <div class="w-full px-[17.5%] h-screen">
                <div class="w-full bg-white shadow rounded-lg px-8 py-8 mt-10">
                    <form @submit.prevent="submit" class="max-w-2xl">
                        <div class="">
                            <InputLabel for="name" value="Nom *" />
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 w-full"
                                v-model="form.name"
                                placeholder="Entrer le nom et prénom"
                                required
                                autofocus
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-2">
                            <InputLabel for="email" value="Email *" />
                            <TextInput
                                id="totem"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                placeholder="Entrer l'email"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-2">
                            <InputLabel for="totem" value="Totem" />
                            <TextInput
                                id="totem"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.totem"
                                placeholder="Entrer le totem"
                            />
                            <InputError class="mt-2" :message="form.errors.totem" />
                        </div>
                        <div class="w-full flex mt-5">
                            <button type="submit" class="text-white font-semibold p-1 px-2 bg-primary rounded-md">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </Layout>
</template>