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
    <div class="w-full flex justify-end pt-2 pr-2">
        <button @click="close" class="bg-red-600 shadow-lg p-1 rounded-md">
            <img src="/icons/cancel.svg" class="h-8 invert pointer-events-none">
        </button>
    </div>
    <div class="w-full h-[600px] flex items-center justify-between">
        <button @click="previousPhoto" class="pr-3 hover:scale-105">
            <img src="/icons/next.svg" class="h-16 rotate-180">
        </button>
        <div class="relative h-full">
            <img :src="photo.path" class="h-full">
        </div>
        <button @click="nextPhoto" class="pl-3 hover:scale-105">
            <img src="/icons/next.svg" class="h-16">
        </button>
    </div>
</template>