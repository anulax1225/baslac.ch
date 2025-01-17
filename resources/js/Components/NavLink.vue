<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex items-center h-full px-3 border-b-2 border-primary'
        : 'flex items-center h-full px-3 hover:scale-110',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
