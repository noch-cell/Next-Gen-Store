<script>
export default {
    name: "TopHeader",
}
</script>
<template>
    <div class="navbar bg-base-100 shadow-sm">
        <div class="flex-1">
            <div class="btn btn-ghost text-xl" @click="emit('toggleSidebar')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                    <path fill-rule="evenodd"
                          d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z"
                          clip-rule="evenodd"/>
                </svg>
            </div>
            <input type="text" placeholder="Search" class="input input-bordered w-auto md:w-[420px]"/>
        </div>
        <div class="flex gap-2">
            <a class="flex items-center ">
                {{currentUser.name}}
            </a>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img
                            alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"/>
                    </div>

                </div>

                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li>

                    </li>
                    <li><a>Settings</a></li>
                    <li>
                        <a @click="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import store from "../store/index.js";
import { useRouter} from "vue-router";
import {computed} from "vue";

const router = useRouter()
const emit = defineEmits(['toggleSidebar']);

function logout() {
    store.dispatch('logout')
        .then(() => {
            router.push({name: 'login'})
        })
}

const currentUser  = computed( () => store.state.user.data)

</script>
<style scoped>

</style>
