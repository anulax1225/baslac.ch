<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Edit from './Edit.vue';
import axios from 'axios';

const props = defineProps({
    photo: {
        type: Object,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
    index: {
        type: Number,
        required: true,
    },
    length: {
        type: Number,
        required: true,
    },
    columns: {
        type: Number,
        default: 3,
    },
});

const emits = defineEmits([ "photo-added", "photo-removed" ]);

let flag = false;

const imageChange = () => {
    flag = !flag;
    if (flag) emits("photo-added", props.photo.uuid);
    else emits("photo-removed", props.photo.uuid);
}

</script>

<template>
    <div :class="{ 
        'border-r': (props.index + 1) % props.columns  != 0, 
        'border-b': props.index < props.length - props.columns, 
        'h-56': props.columns === 3,
    }" 
    class="group relative w-full overflow-hidden border-white hover:scale-[1.003] flex items-center bg-black/90">
        <div class="absolute left-0 right-0 top-0 p-2 flex justify-between">
            <div class="flex items-center">
                <input @click="imageChange" type="checkbox" class="bg-black/50 p-1 rounded-md mr-2" :checked="props.active">
            </div>
        </div>
        <div class="hidden absolute left-0 right-0 bottom-0 p-2 group-hover:flex justify-between flex-wrap items-end">
            <div class="text-right bg-black/30 p-1 px-3 rounded-md mt-1">
                <p class="text-sm text-white">{{ props.photo.name }}</p>
                <p class="text-sm text-white">publier par {{ props.photo.user.name }}</p>
            </div>
        </div>
        <img :src="props.photo.path" class="w-full bg-white">
    </div>
</template>