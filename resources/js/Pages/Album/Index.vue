<script setup>
import { Head } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import Create from './Partials/Create.vue';
import Show from'./Partials/Show.vue';
import { onMounted, reactive } from 'vue';
import Platform from '@/platform';

const props = defineProps({
    albums: {
        type: Array,
        default: []
    },
});

const create = reactive({ active: false });
const viewState = reactive({ square: true, list: false });

const squareView = () => {
    gridState.columns = 3; 
    viewState.square = true; 
    viewState.list = false;
}

const listView = () => {
    gridState.columns = 1; 
    viewState.square = false; 
    viewState.list = true;
}

onMounted(() => {
    if(Platform.detect() == "mobile") {
        listView(); 
    }
});
const gridState = reactive({ columns: 3 });
</script>

<template>
    <Head title="Photos"/>
    <Layout>
        <template #header>
            <div class="w-full flex justify-between items-center py-1">
                <div class="relative flex items-center">
                    <div class="flex items-center bg-white rounded-md shadow-sm shadow-gray-300 overflow-hidden mx-2">
                        <button @click="squareView" :class="{'bg-black/5': viewState.square}" class="flex items-center h-full border-r border-gray-400 p-1
                        hover:bg-black/5">
                            <img src="/icons/block-content.svg" class="h-7">
                        </button>
                        <button @click="listView" :class="{'bg-black/5': viewState.list}" class="flex items-center h-full p-1
                        hover:bg-black/5">
                            <img src="/icons/list.svg" class="h-7">
                        </button>
                    </div>
                </div>
                <div class="relative flex items-center">
                    
                    <button @click="create.active = !create.active" class="flex items-center hover:bg-black/10 rounded-md px-1 py-1">
                        <p class="font-medium laptop:mr-4 mr-1 laptop:text-lg text-sm">Ajouter un album</p>
                        <img src="/icons/add.svg" class="h-8">
                    </button>
                    <Create @close="create.active = !create.active" v-if="create.active" class="absolute -right-0 top-[110%] z-10 mt-4" />
                </div>
            </div>
        </template>
        <template #content>
            <div class="w-full desktop:px-[17.5%] laptop:px-[12.5%] h-full min-h-screen">
                <div class="w-full h-full pb-5 px-1 bg-black/5">
                    <div :class="{'grid-cols-3':  gridState.columns === 3}" 
                    class="w-full grid pt-10">
                        <Show v-for="(album, index) in props.albums" 
                        :album="album" :index="index" :length="props.albums.length" :columns="gridState.columns"
                        />
                    </div>
                </div>
                
            </div>
        </template>
    </Layout>
</template>