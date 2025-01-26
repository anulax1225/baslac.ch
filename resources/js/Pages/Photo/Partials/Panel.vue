<script setup>
import { reactive } from 'vue';
import PanelCreate from './PanelCreate.vue';
import PanelDisplay from './PanelDisplay.vue';
import axios from 'axios';

const props = defineProps({
    album: {
        type: Object,
        required: true,
    }
});

const uuids = async () => {
    let res = await axios.get(route("album.photo.uuid", props.album.uuid));
    console.log(res.data.uuids);
    panelState.uuids = res.data.uuids;
}

const panelState = reactive({ toggle: true, uuids: [] });

const imageState = reactive({
    "url": "",
})

const emits = defineEmits(["close", "data"]);

const imageAdded = (file) => {
    imageState.url = file.url;
} 

const imageRemoved = (file) => {
    imageState.url = "";
} 

uuids();
</script>

<template>
    <div class="text-left text-black shadow-3xl shadow-gray-900 rounded-lg bg-gray-100 overflow-y-auto
    border border-gray-500" :class="{ 'laptop:w-[30rem] w-screen max-h-[calc(100vh/2)]': !panelState.toggle, 'laptop:w-[60rem] w-screen laptop:h-[40rem] laptop:pb-0 pb-32 h-screen': panelState.toggle, }">
        <div v-if="imageState.url && !panelState.toggle" class="max-h-72 overflow-hidden flex items-center">
            <img  :src="imageState.url">
        </div>
        <div class="laptop:px-10 px-2 pb-5 pt-5">
            <div  class="w-full flex justify-between mb-5 items-center">
                <select @change="panelState.toggle = !panelState.toggle" class="bg-gray-200 border-none rounded shadow">
                    <option>Photo Existante</option>
                    <option>Nouvelle photo</option>
                </select>
                <img @click="() => emits('close')" src="/icons/cancel.svg" class="h-7 hover:bg-black/10 rounded-md p-1"> 
            </div>
            <PanelDisplay 
            v-show="panelState.toggle"
            @data="(uuids) => emits('data', uuids)"
            :hidden-photos="panelState.uuids"
            />
            <PanelCreate
            v-show="!panelState.toggle"
            @file-added="imageAdded"
            @file-removed="imageRemoved"
            @data="(uuids) => emits('data', uuids)"
            @close="emits('close')"
            :redirect="false"
            /> 
        </div>
    </div>
</template>