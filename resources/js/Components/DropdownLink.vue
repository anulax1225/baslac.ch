<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-800 transition 
        duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
        :class="{'bg-gray-100': props.active}"
    >
        <slot />
    </Link>
</template>
