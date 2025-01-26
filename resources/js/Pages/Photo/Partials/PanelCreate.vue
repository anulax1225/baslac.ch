<script setup>
import { useForm } from '@inertiajs/vue3';
import File from '@/file';
import Layout from '@/Layouts/Layout.vue';
import Dropzone from '@/Components/Dropzone.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';


const props = defineProps({
    redirect: {
        type: Boolean,
        default: true,
    }
});

const dropzone = ref(null);

const form = useForm({
    name: "",
    path: "",
    redirect: props.redirect, 
})

const emits = defineEmits(["data", "close", "file-added", "file-removed"]);

const imageAdded = (file) => {
    form.path = file.key;
    if(form.name === "") form.name = File.Basename(file.key).split("_")[1];
    emits('file-added', file)
} 

const imageRemoved = (file) => {
    form.path = "";
    emits('file-removed', file)
} 


const submit = async () => {
    if(!props.redirect) {
        let res = await axios.post("/photo", {
            name: form.name,
            path: form.path,
            redirect: false, 
        })
        const uuid = res.data.uuid;
        console.log(uuid, res);
        emits("data", uuid);
    } else {
        form.post("/photo", {
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": document.querySelector('input[name=_token]').value,
        },
    });
    }
    form.path = "";
    form.name = "";
    dropzone.value.removeFiles();
    emits("close");
}
</script>

<template>
    <form @submit.prevent="submit">
        <p>Photo</p>
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
        <TextInput :class="'mb-1 w-full'" v-model="form.name" required :placeholder="'Nom de la photo'"/>
        <InputError :message="form.errors.name"/>
        <div class="w-full flex justify-end mt-3">
            <button type="submit" class="text-white font-semibold p-1 px-2 bg-primary rounded-md">Ajouter</button>
        </div>
    </form>
</template>