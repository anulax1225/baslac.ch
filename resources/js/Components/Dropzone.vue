<template>
    <div @click="openDialog" :id="'dz-' + props.name" @drop="dropFiles" @dragover="Utils.Prevent" @drag="Utils.Prevent" @dragenter="popupShow" @dragleave="popupClose"
    :class="{ 'border-dashed': !props.disabled }"
    class="w-full relative border-2 bg-gray-200  border-1 border-gray-300 overflow-hidden p-4 flex flex-col 
    items-center rounded-lg text-lg text-gray-900 ">
        <div :id="'dz-popup-'+ props.name" class="hidden absolute z-20 bg-gray-400/90 top-0 bottom-0 left-0 right-0 
        pointer-events-none">
            <div class="w-full h-full flex justify-center items-center">
                <img src="/icons/download.png" class="invert absolute h-[80%]">
            </div>
        </div>
        <input @change="fileSelected" :id="'dz-input-' + props.name" type="file" class="hidden" :multiple="props.multiple" :accept="props.accept">
        <div v-for="file in files" class="w-full flex items-center">
            <div class="relative w-full flex justify-between items-center bg-gray-100 
            rounded-lg mb-1 p-2 mr-2 z-0 ">
                <a :href="file.url" target="_blank" class="w-full flex justify-between items-center">
                    <div v-if="file.value.stat === 'loading'" class="absolute top-0 right-0 left-0 bottom-0">
                        <div :style="{ width: file.value.done + '%' }" class="bg-green-600 h-full -z-10 rounded-lg"></div>
                    </div>
                    <div class="flex items-center z-10 mr-8">
                        <img :src="File.Icon(File.Extension(file.value.name))" class="h-10 dark:invert">
                        <p class="font-semibold ml-2">{{ file.value.name }}</p>
                    </div>
                    <div class="text-right z-10">
                        <p>{{ File.SizeToString(file.value.size) }}</p>
                        <p v-if="file.value.stat !== 'loading'" @click="removeFile" :data-name="file.value.name" class="underline text-red-600 text-sm cursor-pointer">Supprimer</p>
                    </div>
                </a>
            </div>
            <div v-if="file.value.stat === 'loading'" class="flex items-center">
                <img src="/icons/loading.svg" class="invert h-10 load-rotate">
            </div>
            <div v-else-if="file.value.stat === 'success'" class="flex items-center">
                <img src="/icons/success.svg" class="h-10">
            </div>
            <div v-else-if="file.value.stat === 'error'" class="flex items-center">
                <img src="/icons/error.svg" class="h-10">
            </div>
        </div>
        <p class="text-black/80 font-medium">{{ empty }}</p>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import File from '@/file';
    import Utils from '@/utils';
    import StorageS3 from '@/storageS3';

    const props = defineProps({
        name: { type: String },
        files: {
            type: Array,
            default: [],
        },
        accept: {
            type: String,
            default: '*',
        },
        multiple: {
            type: Boolean,
            default: true,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        empty: {
            type: String,
            default: 'Ajouter un/des fichier(s)',
        }
    });

    const emit = defineEmits(['file-added', 'file-removed']);
    const files = ref([]);

    props.files.forEach(file => files.value.push(ref(file)));

    defineExpose({ removeFiles: () => files.value = [] });

    const empty = computed(() => {
        return files.value.length ? "" : props.empty; 
    });

    const removeFile = (e) => {
        Utils.Prevent(e);
        const file = files.value.filter(f => f.value.name == e.target.dataset.name)[0];
        files.value = files.value.filter(f => f.value.name != file.value.name);
        emit("file-removed", file.value);
    }

    const addFile = (file) => {
        if(!files.value.filter(fileStat => fileStat.value.name == file.name).length)
        {
            const fileStat = ref({
                name: file.name,
                size: file.size,
                done: 0,
                stat: "loading",
                key: "",
                url: ""
            });
            files.value.push(fileStat);
            StorageS3.UploadFile(file, {
                onUpdate: (done) => 
                {
                    console.log("Uploading : " + done + "% done");
                    fileStat.value.done = done;
                },
                onSuccess: async  (key) => {
                    console.log("Uploaded : " + key);
                    fileStat.value.key = key;
                    fileStat.value.stat = "success";
                    const { url } = await StorageS3.GenerateSignedUrl(key);
                    fileStat.value.url = url;
                    emit("file-added", fileStat.value);
                },
                onError: (e) => {
                    console.log("Failed upload : " + e);
                    fileStat.value.stat = "error";
                }
            });
        }
    }

    const fileSelected = (e) => { [...e.target.files].forEach(file => addFile(file)); } 

    const openDialog = () => { document.querySelector('#dz-input-' + props.name).click(); }
    const dropFiles = (e) => {
        Utils.Prevent(e);
        let popup = document.querySelector(`#dz-popup-${props.name}`);
        if(!popup.classList.contains("hidden")) popup.classList.add("hidden");
        [...e.dataTransfer.items].forEach((item) => {
            if (item.kind === "file" && (!files.value.length || props.multiple === "true")) {
                const file = item.getAsFile();
                if(!files.value.length || props.multiple === "true") addFile(file);
            }
        });

    }
    const popupShow = (e) => { Utils.Prevent(e); document.querySelector(`#dz-popup-${props.name}`).classList.toggle("hidden"); }
    const popupClose = (e) => { Utils.Prevent(e); document.querySelector(`#dz-popup-${props.name}`).classList.toggle("hidden"); }
</script>
