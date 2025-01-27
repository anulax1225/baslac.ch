<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Utils from '@/utils';
import Edit from './Edit.vue';
import axios from 'axios';

const props = defineProps({
    album: {
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

const albumState = reactive({ edit: false });

const deleteAlbum = async (e) => {
    Utils.Prevent(e);
    if(confirm("Voulez-vous vraiment supprimé cette album")){
        form.delete(route("album.destroy", props.album.uuid), {
            headers: {
                "X-CSRF-Token": document.querySelector('input[name=_token]').value,
            }
        });
    }
}
</script>

<template>
    <Link :href="'/album/' + props.album.uuid" :class="{ 
        'border-r': (props.index + 1) % props.columns  != 0, 
        'border-b': props.index < props.length - props.columns, 
        'laptop:h-96 h-44': props.columns === 3,
        'h-[25rem]': props.columns !== 3, 
    }" 
    class="group relative w-full overflow-hidden border-white hover:scale-[1.003] flex items-center bg-black/90">
        <div class="hidden absolute left-0 right-0 top-0 p-2 group-hover:flex justify-between">
            <div class="flex items-center">
                <div class="relative">
                    <button @click="(e) => { Utils.Prevent(e); albumState.edit = !albumState.edit; }" class="bg-black/50 p-1 rounded-md mr-2"><img src="/icons/modify.svg" class="h-6 invert"></button>
                    <!-- <Edit v-if="albumState.edit"
                    @close="() => albumState.edit = false"
                    :album="props.album"
                    :class="'absolute left-0 top-full mt-2'"
                    /> -->
                </div>
                <button @click="deleteAlbum" class="bg-red-600 p-1 rounded-md"><img src="/icons/delete.png" class="h-6 invert"></button>
            </div>
        </div>
        <div class="absolute left-0 right-0 bottom-0 p-2 flex justify-between flex-wrap items-end">
            <p class="laptop:text-sm text-xs text-white bg-black/30 p-1 px-3 rounded">{{ props.album.name }}</p>
            <p class="laptop:text-sm text-xs text-white bg-black/30 p-1 px-3 rounded">publier par {{ props.album.user.name }}</p>
        </div>
        <img :src="props.album.image" class="w-full bg-white">
    </Link>
</template>