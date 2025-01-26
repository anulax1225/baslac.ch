<script setup>
import Dropzone from '@/Components/Dropzone.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Utils from '@/utils';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const picReset = () => {
    form.path = user.path;
}

const user = usePage().props.user;

const form = useForm({
    name: user.name,
    email: user.email,
    totem: user.totem,
    tel: user.tel,
    contactable: user.contactable ? true : false,
    path: user.path,
});

const pic = reactive({ active: false, edit: false });

const submit = () => {
    form.patch(route('profile.update'), { 
        onSuccess: () => { 
            window.location.reload() 
        } 
    });
}
</script>

<template>
    <section class="">
        <header :class="{'items-center' : !pic.edit}" class="flex tablet:flex-row flex-col-reverse tablet:justify-between justify-center">
            <div class="tablet:w-fit tablet:mt-0 w-full mt-5">
                <h2 class="text-xl font-medium text-gray-900">
                    Information Profile 
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Mettre a jour votre profile de compte ici.
                </p>
            </div>
            <div v-if="!pic.edit" @click="pic.active = !pic.active" class="relative">
                <div class="w-32 overflow-hidden flex justify-center rounded-full bg-black/80">
                    <img :src="user.pic" class="h-32" :class="{ 'invert': user.path === 'profiles/none.svg' }">
                </div>
                <div @click="(e) => { Utils.Prevent(e); pic.edit = true; }" :class="{ 'hidden': !pic.active }" 
                class="absolute top-full tablet:right-0 w-40 mt-1 bg-white text-sm text-black/80 rounded-md shadow-xl overflow-hidden">
                    <p class="px-3 py-2 hover:bg-gray-100 hover:scale-[1.01]">Changer la photo</p>
                    <p class="px-3 py-2 hover:bg-gray-100 hover:scale-[1.01]" >Retirer la photo</p>
                </div>
            </div>
            <div v-else class="flex">
                <img @click="(e) => { Utils.Prevent(e); pic.edit = false; pic.active = false; picReset(); }" src="/icons/cancel.svg" class="h-6 mr-2">
                <Dropzone 
                @file-added="(file) => form.path = file.key"
                @file-removed="picReset" 
                :name="'pic'"
                :empty="'Téléversé une photo de profile'"
                :multiple="false"
                :accept="'image/*'"
                />
            </div>
        </header>

        <form @submit.prevent="submit"
        class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Email" />
                <InputLabel class="mt-0.5" for="name" :value="user.email" />
            </div>
            <div>
                <InputLabel for="name" value="Nom *" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    placeholder="Entrer voter nom et prénom"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div>
                <InputLabel for="totem" value="Totem" />
                <TextInput
                    id="totem"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.totem"
                    placeholder="Entrer voter totem"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div>
                <InputLabel for="tel" value="Tel. (ex : 079 666 69 69)" />
                <TextInput
                    id="tel"
                    type="tel"
                    pattern="[0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}"
                    class="mt-1 block w-full"
                    v-model="form.tel"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <div class="flex items-center">
                    <InputLabel class="mr-5" for="tel" value="Contactable" />
                    <input
                        name="contactable"
                        type="checkbox"
                        class="block border border-gray-300 rounded focus:ring-0"
                        v-model="form.contactable"
                        />
                </div>
                
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
