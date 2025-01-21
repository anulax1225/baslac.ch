<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { useSlots } from 'vue';
const slots = useSlots();
const pic = usePage().props.user ? usePage().props.user.pic : "";
usePage().props.user, usePage().props;
const user = usePage().props.auth.user;
</script>

<template>
    <nav class="sticky w-full z-30 top-0 right-0 left-0">
        <div class="w-full h-16 flex px-[17.5%] justify-between border-b border-gray-300 bg-gray-100 text-gray-900">
            <div :class="{ 'w-full': !user }" class="flex h-full justify-between">
                <Link :href="user ? route('photo.index') : route('home')" :class="'h-full mr-5 w-fit'">
                    <img src="/img/logo.png" class="h-full py-1.5">
                </Link>
                <div class="flex text-black/80">
                    <NavLink v-if="!user" :href="route('home')" :active="route().current('home')">
                        Home
                    </NavLink>
                    <!-- <NavLink v-if="!user" :href="'#'" :active="false">
                        Posts
                    </NavLink>
                    <NavLink v-if="!user" :href="route('info')" :active="route().current('info')">
                        Infos
                    </NavLink>
                    <NavLink v-if="!user" :href="'#'" :active="false">
                        News letter
                    </NavLink> -->
                    <NavLink v-if="!user" :href="route('login')" :active="route().current('login')">
                        Log in
                    </NavLink>
                    <NavLink v-if="user" :href="route('photo.index')" :active="route().current('photo.*')">
                        Photothèque
                    </NavLink>
                    <NavLink v-if="user" :href="route('album.index')" :active="route().current('album.*')">
                        Albums
                    </NavLink>
                    <NavLink v-if="user" :href="route('admin.user.index')" :active="route().current('admin.*')">
                        Admin
                    </NavLink>
                </div>
            </div>
            <div v-if="user" class="relative flex items-center z-40">
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <span class="flex rounded-md hover:cursor-pointer focus:cursor-pointer">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 
                                font-medium rounded-md text-black/80 hover:text-gray-700 
                                dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <p class="mr-2">{{ user.name }}</p>

                                <div class="w-10 overflow-hidden rounded-full bg-black/80 flex justify-center items-center">
                                    <img :src="pic" class="h-10">
                                </div>
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('profile.edit')" :active="route().current('profile.edit')">Profile</DropdownLink>
                        <DropdownLink :href="route('logout')">Log Out</DropdownLink>
                    </template>
                </Dropdown>
            </div>
        </div>
        <div v-if="slots.header" class="w-full max-h-[3.5rem] px-[17.5%] py-auto bg-gray-50 border-b border-gray-300 text-gray-900">
            <slot name="header"/>
        </div>
    </nav>
    <slot name="content"/>
    <footer class="w-full px-[17.5%] bg-gray-50 text-gray-900 flex items-center justify-between">
        <p class="italic text-gray-600">&copy; 2024 Propriété de l'association Scout Bas-Lac</p>
        <div class="flex my-8">
            <div class="group mx-2">
                <div class="group-hover:social-icon-in social-icon-out p-2 border border-gray-600 rounded-lg">
                    <img src="/icons/facebook.svg" class="w-[2rem] group-hover:icon-in icon-out dark:invert">
                </div>
            </div>
            <div class="group mx-2">
                <a target="_blank" href="https://www.instagram.com/scouts_baslac/">
                    <div class="group group-hover:social-icon-in social-icon-out p-2 border border-gray-600 rounded-lg">
                        <img src="/icons/instagram.svg" class="w-[2rem] group-hover:icon-in icon-out dark:invert">
                    </div> 
                </a>
            </div>
            <div class="group mx-2">
                <a target="_blank" href="mailto:groupe-baslac@gmail.com">
                    <div class="group group-hover:social-icon-in social-icon-out p-2 border border-gray-600 rounded-lg">
                        <img src="/icons/mail.svg" class="w-[2rem] group-hover:icon-in icon-out dark:invert">
                    </div>
                </a>
            </div>
        </div>
    </footer>
</template>