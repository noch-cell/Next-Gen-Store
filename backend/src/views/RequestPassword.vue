<template>

    <guest-layout title="Request New Password">
        <div>
            <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
            <div class="mt-2">
                <input type="email" name="email" id="email" autocomplete="email" required=""
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
            </div>
        </div>
        <div class="text-sm">
            <router-link :to="{name : 'login'}"
                         class="font-semibold text-indigo-600 hover:text-indigo-500">Remember Your Password?
            </router-link>
        </div>
        <div>
            <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Request Password
            </button>
        </div>
    </guest-layout>

</template>

<style scoped>

</style>
<script setup lang="ts">
import GuestLayout from "../components/GuestLayout.vue";
</script>
