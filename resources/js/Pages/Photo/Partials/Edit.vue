<script setup>
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    photo: {
        type: Object,
        required: true,
    }
})

const form = useForm({
    name: ""
});

const emits = defineEmits(["close"]);

const submit = () => {
    form.post("/photo/" + props.photo.uuid , {
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": document.querySelector('input[name=_token]').value,
        },
    });
    form.name = "";
    emits("close");
}
</script>

<template>
    <div class="text-left text-black shadow-md shadow-gray-500 rounded-lg 
    bg-gray-50 overflow-hidden border border-gray-300 p-2 laptop:w-72 w-full" >
    <form @submit.prevent="submit">
        <TextInput :placeholder="'Changer le nom de la photo'" :class="'w-full'" v-model="form.name"/>
        <div class="w-full flex mt-3">
            <button type="submit" class="text-white font-semibold p-1 px-2 bg-primary rounded-md">Changer</button>
        </div>
    </form>
    </div>
</template>