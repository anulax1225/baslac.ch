<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import Dropzone from '@/Components/Dropzone.vue';
import Create from './Partials/Create.vue';
import Show from'./Partials/Show.vue';
import Modal from './Partials/Modal.vue';
import { onMounted, reactive, ref } from 'vue';
import Platform from '@/platform';

const props = defineProps({
    photos: {
        type: Array,
        default: []
    },
    lastPage: {
        type: Number,
        default: 1,
    }
});   
const create = reactive({ active: false });

const form = useForm();

const fullScreenState = reactive({ photo: {}, active: false });
const photoState = reactive({ square: true, list: false, pageCount: 1, photos: props.photos });


const fullScreen = (photo) => {
    fullScreenState.photo = photo;
    fullScreenState.active = true;
    photoState.square = false; 
    photoState.list = false;
    toggle();
}

const gridState = reactive({ columns: 3 });

const squareView = () => {
    gridState.columns = 3; 
    fullScreenState.active = false;
    photoState.square = true; 
    photoState.list = false;
    toggle();
}

const listView = () => {
    gridState.columns = 1; 
    fullScreenState.active = false;
    photoState.square = false; 
    photoState.list = true;
    toggle();
}

const loadPhotos = async () => {
    photoState.pageCount++;
    const res = await axios.get(route("photo.page", photoState.pageCount)); 
    photoState.photos = photoState.photos.concat(res.data.photos)
    console.log("hello", res.data.photos, photoState.photos, props.lastPage)
}

const deletePhoto = (uuid) => {
    if(confirm("Voulez-vous vraiment supprimé cette photo")){
        form.delete("/photo/" + uuid, {
            headers: {
                "X-CSRF-Token": document.querySelector('input[name=_token]').value,
            },
            onSuccess: () => {
                photoState.photos = photoState.photos.filter(photo => photo.uuid != uuid);
            }
        });
    }
}

const toggle = () => {
    document.querySelector('#affichage').classList.toggle('hidden');
    document.querySelector('#affichage').classList.toggle('flex');
}

onMounted(() => {
    if(Platform.detect() == "mobile") {
        listView(); 
        toggle();
    }
});
</script>

<template>
    <Head title="Photos"/>
    <Layout>
        <template #header>
            <div class="w-full flex justify-between items-center py-1">
                <div class="relative flex items-center">
                    <p class="font-semibold laptop:mr-4 mr-1 laptop:text-lg text-sm hidden laptop:block">Affichage</p>
                    <p @click="toggle"
                    class="font-semibold laptop:mr-4 mr-1 laptop:text-lg text-sm laptop:hidden">Affichage</p>
                    <div id="affichage" class="absolute laptop:static hidden top-full mt-1 laptop:flex laptop:flex-row flex-col items-center bg-white rounded-md shadow-sm shadow-gray-300 overflow-hidden">
                        <button @click="squareView" :class="{'bg-black/5': photoState.square}" class="flex items-center h-full laptop:border-r laptop:border-b-0  border-b border-gray-400 p-1
                        hover:bg-black/5">
                            <img src="/icons/block-content.svg" class="h-7">
                        </button>
                        <button @click="listView" :class="{'bg-black/5': photoState.list}" class="flex items-center h-full laptop:border-r laptop:border-b-0  border-b border-gray-400 p-1
                        hover:bg-black/5">
                            <img src="/icons/list.svg" class="h-7">
                        </button>
                        <button @click="() => fullScreen(photoState.photos[0].uuid)" :class="{'bg-black/5': fullScreenState.active}" class="flex items-center p-1
                            hover:bg-black/5">
                            <img src="/icons/slider.svg" class="h-7">
                        </button>
                    </div>
                </div>
                <div class="relative flex items-center">
                    
                    <button @click="create.active = !create.active" class="flex items-center hover:bg-black/10 rounded-md px-2 py-1">
                        <p class="font-medium laptop:mr-4 mr-1 laptop:text-lg text-sm">Ajouter une photo</p>
                        <img src="/icons/add.svg" class="h-8">
                    </button>
                    <Create @close="create.active = !create.active" v-if="create.active" class="absolute right-0 top-[110%] z-10 mt-4" />
                </div>
            </div>
        </template>
        <template #content>
            <div class="w-full desktop:px-[17.5%] laptop:px-[12.5%] h-full">
                <div class="w-full h-full pb-20 bg-black/5">
                    <div v-if="!fullScreenState.active" :class="{'grid-cols-3':  gridState.columns === 3}" 
                    class="w-full grid pt-10">
                        <Show v-for="(photo, index) in photoState.photos" 
                        :photo="photo" :index="index" :length="photoState.photos.length" :columns="gridState.columns"
                        @full-screen="fullScreen"
                        @delete-photo="deletePhoto"
                        />
                    </div>
                    <div v-if="!fullScreenState.active && photoState.pageCount < props.lastPage" class="w-full pt-5 flex items-center justify-center">
                        <button @click="loadPhotos"
                        class="bg-gray-100 p-2 font-medium text-gray-700 rounded shadow hover:scale-[1.01]">Afficher plus de photos</button>
                    </div>
                    <Modal v-if="fullScreenState.active" :photoId="fullScreenState.photo" :photos="photoState.photos"
                    @close="() => { fullScreenState.photo = {}; fullScreenState.active = false; }"
                    />
                </div>
                
            </div>
        </template>
    </Layout>
</template>