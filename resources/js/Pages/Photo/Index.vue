<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Dropzone from '@/Components/Dropzone.vue';
import Create from './Partials/Create.vue';
import Show from'./Partials/Show.vue';
import Modal from './Partials/Modal.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    photos: {
        type: Array,
        default: []
    },
    active: false
});

const create = reactive({ active: false });

const fullScreenState = reactive({ photo: {}, active: false });

const fullScreen = (photo) => {
    fullScreenState.photo = photo;
    fullScreenState.active = true;
}

const gridState = reactive({ columns: 3 });
</script>

<template>
    <Head title="Photos"/>

    <Modal v-if="fullScreenState.active" :photoId="fullScreenState.photo" :photos="props.photos"
    @close="() => { fullScreenState.photo = {}; fullScreenState.active = false; }"
    />
    <GuestLayout>
        <template #header>
            <div class="w-full flex justify-between items-center py-1">
                <div class="relative flex items-center">
                    <p class="font-semibold mr-4">Affichage</p>
                    <div class="flex items-center bg-white rounded-md shadow-sm shadow-gray-300 overflow-hidden">
                        <button @click="gridState.columns = 3" class="flex items-center h-full border-r border-gray-400 p-1
                        hover:bg-black/5">
                            <img src="/icons/block-content.svg" class="h-7">
                        </button>
                        <button @click="gridState.columns = 1" class="flex items-center h-full border-r border-gray-400 p-1
                        hover:bg-black/5">
                            <img src="/icons/list.svg" class="h-7">
                        </button>
                        <button @click="() => fullScreen(props.photos[0].uuid)" class="flex items-center p-1
                            hover:bg-black/5">
                            <img src="/icons/slider.svg" class="h-7">
                        </button>
                    </div>
                </div>
                <div class="relative flex items-center">
                    
                    <button @click="create.active = !create.active" class="flex items-center hover:bg-black/10 rounded-md px-2 py-1">
                        <p class="font-semibold mr-4">Ajouter une photo</p>
                        <img src="/icons/add.svg" class="h-8">
                    </button>
                    <Create @close="create.active = !create.active" v-if="create.active" class="absolute -right-0 top-[110%] z-10 mt-4" />
                </div>
            </div>
        </template>
        <template #content>
            <div class="w-full px-[17.5%] min-h-screen">
                <div class="w-full h-full bg-black/10 py-20 px-1">
                    <div :class="{'grid-cols-3':  gridState.columns === 3}" 
                    class="w-full grid">
                        <Show v-for="(photo, index) in props.photos" 
                        :photo="photo" :index="index" :length="props.photos.length" :columns="gridState.columns"
                        @full-screen="fullScreen"
                        />
                    </div>
                </div>
                
            </div>
        </template>
    </GuestLayout>
</template>