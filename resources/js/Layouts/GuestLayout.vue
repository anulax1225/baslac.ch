<script setup>
import { Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <nav class="sticky w-full z-10 h-16 top-0 right-0 left-0 bg-gray-50 text-gray-900">
        <div class="w-full h-full flex px-[17.5%] justify-between border-b border-gray-300">
            <div class="h-full flex">
                <Link :href="route('home')" class="h-full mr-10">
                    <img src="/img/logo.png" class="h-full py-1.5">
                </Link>
            </div>
            <div class="flex font-semibold">
                <NavLink :href="route('home')" :active="route().current('home')">
                    Home
                </NavLink>
                <NavLink :href="route('photo.index')" :active="route().current('photo.index')">
                    Photothèque
                </NavLink>
                <NavLink :href="'#'" :active="false">
                    Posts
                </NavLink>
                <NavLink :href="route('info')" :active="route().current('info')">
                    Infos
                </NavLink>
                <NavLink :href="'#'" :active="false">
                    News letter
                </NavLink>
            </div>
        </div>
    </nav>
    <slot name="content"/>
    <footer class="w-full px-[17.5%] bg-gray-50 text-gray-900 flex items-center justify-between">
        <p class="italic text-gray-600">&copy; 2024 Propriété de l'association Scout Bas-Lac</p>
        <div class="flex my-8">
            <div class="group mx-2">
                <div class="group-hover:social-icon-in social-icon-out p-2 border border-gray-600 rounded-lg">
                    <img src="/img/facebook.svg" class="w-[2rem] group-hover:icon-in icon-out dark:invert">
                </div>
            </div>
            <div class="group mx-2">
                <div class="group group-hover:social-icon-in social-icon-out p-2 border border-gray-600 rounded-lg">
                    <img src="/img/instagram.svg" class="w-[2rem] group-hover:icon-in icon-out dark:invert">
                </div>
            </div>
            <div class="group mx-2">
                <div class="group group-hover:social-icon-in social-icon-out p-2 border border-gray-600 rounded-lg">
                    <img src="/img/mail.svg" class="w-[2rem] group-hover:icon-in icon-out dark:invert">
                </div>
            </div>
        </div>
    </footer>
</template>