<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Edit from './Edit.vue';
import axios from 'axios';

const props = defineProps({
    photo: {
        type: Object,
        required: true,
    },
    index: {
        type: Number,
        required: true,
    },
    length: {
        type: Number,
        required: true,
    },
    columns: {
        type: Number,
        default: 3,
    },
});

const form = useForm();

const photoState = reactive({ edit: false });

const emits = defineEmits(["full-screen"]);

const deletePhoto = async () => {
    if(confirm("Voulez-vous vraiment supprimé cette photo")){
        form.delete("/photo/" + props.photo.uuid, {
            headers: {
                "X-CSRF-Token": document.querySelector('input[name=_token]').value,
            }
        });
    }
}
</script>

<template>
    <div :class="{ 
        'border-r': (props.index + 1) % props.columns  != 0, 
        'border-b': props.index < props.length - props.columns, 
        'h-96': props.columns === 3,
        'h-[25rem]': props.columns !== 3, 
    }" 
    class="group relative w-full overflow-hidden border-white hover:scale-[1.003] flex items-center bg-black/90">
        <div class="hidden absolute left-0 right-0 top-0 p-2 group-hover:flex justify-between">
            <div class="flex items-center">
                <button @click="() => emits('full-screen', props.photo.uuid)" class="bg-black/50 p-1 rounded-md mr-2"><img src="/icons/full-screen.svg" class="h-6 invert"></button>
                <div class="relative">
                    <button @click="photoState.edit = !photoState.edit" class="bg-black/50 p-1 rounded-md mr-2"><img src="/icons/modify.svg" class="h-6 invert"></button>
                    <Edit v-if="photoState.edit"
                    @close="() => photoState.edit = false"
                    :photo="props.photo"
                    :class="'absolute left-0 top-full mt-2'"
                    />
                </div>
                <button @click="deletePhoto" class="bg-red-600 p-1 rounded-md"><img src="/icons/delete.png" class="h-6 invert"></button>
            </div>
            <div class="text-right bg-black/30 p-1 px-3 rounded-md">
                <p class="text-sm text-white">{{ props.photo.name }}</p>
                <p class="text-sm text-white">publier par {{ props.photo.user.name }}</p>
            </div>
        </div>
        <div class="hidden absolute left-0 right-0 bottom-0 p-2 group-hover:flex justify-end">
            <a :href="props.photo.path" target="_blank" class="bg-black/50 p-1 rounded-md"><img src="/icons/download.png" class="h-6 invert"></a>
        </div>
        <img :src="props.photo.path" class="w-full bg-white">
    </div>
</template>