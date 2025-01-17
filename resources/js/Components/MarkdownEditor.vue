<script setup>
    import { markdown } from 'markdown';

    const keyHandle = (e) => { render(); }

    const render = () => {
        let input = document.querySelector("#md-input").value;
        document.querySelector("#markdown-html").innerHTML = markdown.toHTML(input);
    }

    const remove = () => {
        document.querySelector("#md-input").value = "";
        document.querySelector("#markdown-html").innerHTML = "";
    } 

    const switchMode = () => {
        document.querySelector("#md-input").classList.toggle('hidden');
        document.querySelector("#markdown-html").classList.toggle('hidden');
        document.querySelector("#btn-switch").textContent = document.querySelector("#md-input").classList.contains('hidden') ? "Text Mode" : "Page Mode";
    }
</script>

<template>
    <div class="w-full h-full rounded-md overflow-hidden border-b border-gray-300 shadow-md shadow-gray-100">
        <div class="w-full flex justify-between bg-gray-100">
            <div class="flex">
                <button class="p-3 bg-gray-200 border-r border-gray-300"><img src="/img/title.svg" class="h-5"></button>
                <button class="p-3 bg-gray-200 border-r border-gray-300"><img src="/img/add-image.svg" class="h-5"></button>
                <button class="p-3 bg-gray-200 border-r border-gray-300"><img src="/img/bold.svg" class="h-5"></button>
                <button class="p-3 bg-gray-200 border-r border-gray-300"><img src="/img/italic.svg" class="h-5"></button>
                <button class="p-3 bg-gray-200"><img src="/img/block-quote.svg" class="h-5"></button>
            </div>
            <div class="flex">
                <button id="btn-switch" @click="switchMode()" class="p-2 bg-blue-600 text-white font-bold ">Text Mode</button>
                <button @click="remove()" class="p-2 bg-red-600 text-white font-bold ">Effacer</button>
            </div>
        </div>
        <div class="w-full h-full border-t border-l border-r border-gray-300 ">
            <div id="markdown-html" class="md-content p-3 overflow-scroll">

            </div>
            <textarea id="md-input" class="hidden border-none h-full resize-none text-lg text-gray-700 font-semibold focus:ring-0 overflow-scroll" @keydown="keyHandle"></textarea>
        </div>
    </div>
</template>
