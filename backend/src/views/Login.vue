<template>

    <guest-layout title="Sing in here">
        <form class="mt-8 space-y-6" method="POST" @submit.prevent="login">
            <div>
                <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                <div class="mt-2">
                    <input type="email" name="email" id="email" autocomplete="email"  v-model="user.email"
                           class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                </div>

            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    <div class="text-sm">
                        <router-link :to="{name : 'requestPassword'}"
                                     class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?
                        </router-link>
                    </div>
                </div>
                <div class="mt-2">
                    <input type="password" name="password" id="password" autocomplete="current-password"
                           v-model="user.password"
                           class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" checked="checked" class="checkbox " v-model="user.remember"/>
                <span>Remember me </span>
            </div>

<!--           Error message display-->
            <div v-if="error" role="alert" class="alert alert-error">
                <span @click="error  = ''" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                </span>

                <span>{{ error}}</span>
            </div>

            <div>
                <button type="submit"
                        :disabled="loading"
                        class="btn btn-primary w-full justify-center "
                        :class="{
                            'class-not-allow' : loading ,
                        }"
                >
                    <span v-if="loading" class="loading loading-spinner loading-lg"></span>
                    Sign in
                </button>

            </div>

        </form>
    </guest-layout>

</template>


<script setup>
import {ref} from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import store from "../store/index.js";
import { useRouter} from "vue-router";

const router = useRouter()

let loading = ref(false)
let error = ref("")

const user = {
    email: '',
    password: '',
    remember: false
}

function login() {
    loading.value = true;
    store.dispatch('login', user)
        .then(() => {
            loading.value = false;
            router.push({name: 'app.dashboard'});
        })
        .catch(({response}) => {
            loading.value = false;
            error.value = response.data.message;
        });
}
</script>
