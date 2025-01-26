<script setup>
import { reactive } from 'vue';
import PanelCreate from './PanelCreate.vue';

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

</script>

<template>
    <div class="text-left text-black laptop:w-[30rem] w-screen shadow-2xl rounded-lg bg-gray-50 overflow-hidden
    border border-gray-300">
        <div v-if="imageState.url" class="max-h-72 overflow-hidden flex items-center">
            <img  :src="imageState.url">
        </div>
        <div class="laptop:px-10 px-2 pb-5 pt-5">
            <div @click="() => emits('close')" class="w-full flex justify-end ">
                <img src="/icons/cancel.svg" class="h-7 hover:bg-black/10 rounded-md p-1"> 
            </div>
            <PanelCreate
            @file-added="imageAdded"
            @file-removed="imageRemoved"
            @close="emits('close')"
            /> 
        </div>
    </div>
</template>