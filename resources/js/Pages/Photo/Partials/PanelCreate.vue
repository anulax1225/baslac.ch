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
    files: [],
    redirect: props.redirect, 
})

const emits = defineEmits(["data", "close", "file-added", "file-removed"]);

const imageAdded = (file) => {
    form.files.push({
        name: File.Basename(file.key).split("_")[1],
        original_name: File.Basename(file.key).split("_")[1] + "." + File.Extension(file.key),
        path:file.key,
    });
    emits('file-added', file)
} 

const imageRemoved = (file) => {
    form.path = "";
    emits('file-removed', file)
} 


const submit = async () => {
    if(!props.redirect) {
        let res = await axios.post("/photos", {
            files: form.files,
            redirect: false, 
        }, {
            headers: {
                "Content-Type": "application/json",
            }
        })
        const uuids = res.data.uuids;
        console.log(uuids, res);
        emits("data", uuids);
    } else {
        form.post("/photos", {
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('input[name=_token]').value,
            },
            onSuccess: () => window.location.reload()
        });
    }
    form.files = [];
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
        :accept="'image/*'"
        :class="'mb-1'" 
        />
        <InputError :message="form.errors.path"/>
        <TextInput v-for="file in form.files" :class="'mb-1 w-full'" v-model="file.name" required :placeholder="'Changer le nom de l\'image ' + file.original_name"/>
        <InputError :message="form.errors.name"/>
        <div class="w-full flex justify-end mt-3">
            <button type="submit" class="text-white font-semibold p-1 px-2 bg-primary rounded-md">Ajouter</button>
        </div>
    </form>
</template>