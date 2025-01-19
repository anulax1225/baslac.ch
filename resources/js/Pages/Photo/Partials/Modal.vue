<script setup>
import { reactive } from 'vue';


const props = defineProps({
    photoId: {
        type: String,
        required: true,
    },
    photos: {
        type: Array,
        required: true
    }
});

const photo = reactive({ uuid: props.photoId, path: props.photos.filter(photo => photo.uuid == props.photoId)[0].path });

const emit = defineEmits(['close']);

const nextPhoto = () => {
    let nextPhoto = { uuid: props.photos[0].uuid, path: props.photos[0].path };
    let check = false;
    props.photos.every((ph) => {
        if(check) {
            nextPhoto = ph;
            return false;
        }
        check = ph.uuid == photo.uuid;
        return true;
    });
    photo.path = nextPhoto.path;
    photo.uuid = nextPhoto.uuid;
}

const previousPhoto = () => {
    let nextPhoto = { uuid: props.photos[props.photos.length - 1].uuid, path: props.photos[props.photos.length - 1].path };
    let check = false;
    props.photos.reverse().every((ph) => {
        if(check) {
            nextPhoto = ph;
            return false;
        }
        check = ph.uuid == photo.uuid;
        return true;
    });
    props.photos.reverse();
    photo.path = nextPhoto.path;
    photo.uuid = nextPhoto.uuid;
}

const close = () => { emit('close'); };

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

</script>

<template>
    <div @keypress="closeOnEscape" id="modal-image" class="fixed z-40 modal-base top-0 bottom-0 left-0 right-0 bg-black/90">
        <div class="w-full h-full flex items-center justify-center z-50">
            <button @click="previousPhoto" class="pr-3 hover:scale-105">
                <img src="/icons/next.svg" class="h-16 invert rotate-180">
            </button>
            <div class="relative h-4/5 max-h-5xl">
                <div class="absolute right-0 p-4">
                    <button @click="close" class="bg-red-600 shadow-md shadow-gray-600 p-1 rounded-md">
                        <img src="/icons/cancel.svg" class="h-8 invert pointer-events-none">
                    </button>
                </div>
                <img :src="photo.path" class="h-full">
            </div>
            <button @click="nextPhoto" class="pl-3 hover:scale-105">
                <img src="/icons/next.svg" class="h-16 invert">
            </button>
        </div>
    </div>

</template>