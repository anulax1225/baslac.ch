<script setup>
import axios from 'axios';
import { reactive } from 'vue';
import Show from './Show.vue';
import PanelShow from './PanelShow.vue';
const props = defineProps({
    hiddenPhotos: {
        type: Array,
        default: []
    }
})
const emits = defineEmits(["data"]);

const albumState = reactive({albums: [], focusAlbum: "", photos: [], pageCount: 1, lastPage: 1});

let photos = [];


const loadPhotos = async (album, page) => {
    if(!album || album === "") {
        let res = await axios.get(route("photo.page", page));
        albumState.photos = albumState.photos.concat(res.data.photos);
        albumState.lastPage = res.data.lastPage;
    } else {
        let res = await axios.get("/album/" + album + "/page/" + page);
        albumState.photos = albumState.photos.concat(res.data.photos);
        albumState.lastPage = res.data.lastPage;
    }
}
const loadAlbum = (album) => {
    albumState.photos = [];
    albumState.focusAlbum = album;
    albumState.pageCount = 1;
    loadPhotos(albumState.focusAlbum, albumState.pageCount);
}

const loadAlbums = async (page) => {
    let res = await axios.get(route("album.page", page));
    albumState.albums = res.data.albums;
}
const initLoad = async () => {
    await loadAlbums(1);
    loadAlbum("");
}
initLoad();
</script>

<template>
<div class="flex pb-10 h-[35rem]">
    <div class="flex flex-col items-start justify-between w-32 border-r border-gray-200 pr-2">
        <div class="w-full">
            <p class="my-1 py-1 px-2  text-gray-700 rounded shadow"
            @click="loadAlbum('')"
            :class="{ 'bg-gray-200': albumState.focusAlbum === '', 'bg-gray-100': albumState.focusAlbum !== ''}">Photothèque</p>
            <p v-for="album in albumState.albums" 
            @click="loadAlbum(album.uuid)"
            class="my-1 py-1 px-2 bg-gray-100 text-gray-700 
            overflow-hidden text-nowrap rounded shadow" 
            :class="{ 'bg-gray-200': albumState.focusAlbum === album.uuid, 'bg-gray-100': albumState.focusAlbum !== album.uuid}">{{ album.name }}</p>
            <p class="my-1 py-1 px-2 bg-gray-100 text-gray-700  rounded shadow">plus d'album</p>
        </div>
        <button @click="emits('data', photos)" class="text-white font-semibold p-1 px-2 bg-primary rounded-md">Ajouter</button>
    </div>
    <div class="w-[calc(100%-8rem)] h-full overflow-y-scroll py-5 ml-2">
        <div class="grid grid-cols-3">
            <PanelShow v-for="(photo, index) in albumState.photos" v-show="!props.hiddenPhotos.includes(photo.uuid)" :photo="photo"
            :index="index" :length="albumState.photos.length" :columns="3" :active="photos.includes(photo.uuid)"
            @photo-added="(uuid) => { if(!photos.includes(uuid)) photos.push(uuid) }"
            @photo-removed="(uuid) => { if(photos.includes(uuid)) photos = photos.filter(uu => uu != uuid) }"
            />
        </div>
        <div v-if="albumState.pageCount < albumState.lastPage" class="py-2 w-full flex justify-center">
            <button @click="loadPhotos(albumState.focusAlbum, ++albumState.pageCount)" class="bg-gray-100 p-2 font-medium text-gray-700 
            rounded shadow hover:scale-[1.01]">Afficher plus de photos</button>
        </div>
    </div>
</div>
</template>