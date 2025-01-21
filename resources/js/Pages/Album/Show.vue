<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import Create from '@/Pages/Photo/Partials/Create.vue';
import Show from'@/Pages/Photo/Partials/Show.vue';
import Modal from '@/Pages/Photo/Partials/Modal.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    album: {
        type: Object,
        default: {}
    },
    photos: {
        type: Array,
        default: []
    },
});   

const form = useForm({ uuid: "" });
const create = reactive({ active: false });

const fullScreenState = reactive({ photo: {}, active: false });
const viewState = reactive({ square: true, list: false });

const fullScreen = (photo) => {
    fullScreenState.photo = photo;
    fullScreenState.active = true;
    viewState.square = false; 
    viewState.list = false;
}

const gridState = reactive({ columns: 3 });

const squareView = () => {
    gridState.columns = 3; 
    fullScreenState.active = false;
    viewState.square = true; 
    viewState.list = false;
}

const listView = () => {
    gridState.columns = 1; 
    fullScreenState.active = false;
    viewState.square = false; 
    viewState.list = true;
}

const addPhoto = (uuid) => {
    console.log("uuid");
    form.uuid = uuid;
    form.post("/album/" + props.album.uuid + "/add",{
        headers: {
            "X-CSRF-Token": document.querySelector('input[name=_token]').value,
        },
    });
}
</script>

<template>
    <Head title="Photos"/>
    <Layout>
        <template #header>
            <div class="w-full flex justify-between items-center py-1">
                <div class="relative flex items-center">
                    <p class="font-semibold mr-4">Affichage</p>
                    <div class="flex items-center bg-white rounded-md shadow-sm shadow-gray-300 overflow-hidden">
                        <button @click="squareView" :class="{'bg-black/5': viewState.square}" class="flex items-center h-full border-r border-gray-400 p-1
                        hover:bg-black/5">
                            <img src="/icons/block-content.svg" class="h-7">
                        </button>
                        <button @click="listView" :class="{'bg-black/5': viewState.list}" class="flex items-center h-full border-r border-gray-400 p-1
                        hover:bg-black/5">
                            <img src="/icons/list.svg" class="h-7">
                        </button>
                        <button @click="() => fullScreen(props.photos[0].uuid)" :class="{'bg-black/5': fullScreenState.active}" class="flex items-center p-1
                            hover:bg-black/5">
                            <img src="/icons/slider.svg" class="h-7">
                        </button>
                    </div>
                </div>
                <div class="relative flex items-center">
                    
                    <button @click="create.active = !create.active" class="flex items-center hover:bg-black/10 rounded-md px-2 py-1">
                        <p class="font-medium mr-4">Ajouter une photo</p>
                        <img src="/icons/add.svg" class="h-8">
                    </button>
                    <Create :redirect="false" @data="(uuid) => addPhoto(uuid)" @close="create.active = !create.active" v-if="create.active" class="absolute -right-0 top-[110%] z-10 mt-4" />
                </div>
            </div>
        </template>
        <template #content>
            <div class="w-full px-[17.5%] h-full">
                <div v-if="!fullScreenState.active" class="w-full h-96 flex items-stretch justify-stretch overflow-hidden">
                    <img :src="album.image">
                    <div class="w-full h-full px-10 py-6">
                        <p class="text-7xl font-extrabold text-black/90">{{ album.name }}</p>
                        <p class="pt-1 pl-2 text-2xl font-extrabold text-black/90">publiée le {{ album.created_at }}</p>
                    </div>
                </div>
                <div class="w-full h-full pb-20 px-1 bg-black/5">
                    <div v-if="!fullScreenState.active" :class="{'grid-cols-3':  gridState.columns === 3}" 
                    class="w-full grid pt-10">
                        <Show v-for="(photo, index) in props.photos" 
                        :photo="photo" :index="index" :length="props.photos.length" :columns="gridState.columns"
                        @full-screen="fullScreen"
                        />
                    </div>
                    <Modal v-if="fullScreenState.active" :photoId="fullScreenState.photo" :photos="props.photos"
                    @close="() => { fullScreenState.photo = {}; fullScreenState.active = false; }"
                    />
                </div>
                
            </div>
        </template>
    </Layout>
</template>