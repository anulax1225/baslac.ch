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
    <div class="text-left text-black shadow-2xl rounded-lg bg-gray-50
    border border-gray-300" :class="{ 'w-[30rem]': !panelState.toggle, 'w-[60rem] h-[40rem]': panelState.toggle, }">
        <div v-if="imageState.url" class="max-h-72 overflow-hidden flex items-center">
            <img  :src="imageState.url">
        </div>
        <div class="px-10 pb-5 pt-5">
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
            @data="(uuid) => emits('data', [uuid])"
            @close="emits('close')"
            :redirect="false"
            /> 
        </div>
    </div>
</template>