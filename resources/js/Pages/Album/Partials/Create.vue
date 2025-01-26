<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import File from '@/file';
import Layout from '@/Layouts/Layout.vue';
import Dropzone from '@/Components/Dropzone.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { onMounted, reactive, ref } from 'vue';

const dropzone = ref(null);

const imageState = reactive({
    "url": "",
})

const form = useForm({
    name: "",
    path: "", 
})

const emits = defineEmits(["close"]);

const imageAdded = (file) => {
    form.path = file.key;
    imageState.url = file.url;
    if(form.name === "") form.name = File.Basename(file.key).split("_")[1];
} 

const imageRemoved = (file) => {
    form.path = "";
} 

const submit = () => {
    form.post("/album", {
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": document.querySelector('input[name=_token]').value,
        },
    });

    imageState.url = "";
    form.path = "";
    form.name = "";
    dropzone.value.removeFiles();
    emits("close");
}
</script>

<template>
    <div class="text-left text-black laptop:w-[30rem] w-screen shadow-xl rounded-lg bg-gray-50 overflow-hidden
    border border-gray-300">
        <div v-if="imageState.url" class="max-h-72 overflow-hidden flex items-center">
            <img  :src="imageState.url">
        </div>
        <div class="Laptop:px-10 px-2 pb-5 pt-5">
            <div @click="() => emits('close')" class="w-full flex justify-end ">
                <img src="/icons/cancel.svg" class="h-7 hover:bg-black/10 rounded-md p-1"> 
            </div>
            <form @submit.prevent="submit">
                <p>Couverture de l'album</p>
                <Dropzone
                ref="dropzone"
                @file-added="imageAdded"
                @file-removed="imageRemoved" 
                :name="photos"
                :empty="'Téléversé une image'"
                :multiple="false"
                :accept="'image/*'"
                :class="'mb-1'" 
                />
                <InputError :message="form.errors.path"/>
                <p class="mt-3">Nom</p>
                <TextInput :class="'mb-1 w-full'" v-model="form.name" required :placeholder="'Nom de l\'album'"/>
                <InputError :message="form.errors.name"/>
                <div class="w-full flex justify-end mt-3">
                    <button type="submit" class="text-white font-semibold p-1 px-2 bg-primary rounded-md">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</template>