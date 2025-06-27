<script>
export default {
    name: "SideBar"
}
</script>
<template>
    <ul class="menu menu-xl bg-base-200  rounded-box w-56">
        <li>
            <RouterLink :to="{name : 'app.dashboard'}">
                <div class="flex items-center py-2 px-3">
                    <span class="mr-2 ">
                        <HomeIcon class="w-6"/>
                    </span>
                    <span>
                        Dashboard
                    </span>
                </div>
            </RouterLink>
        </li>
        <li>
            <RouterLink :to="{name : 'app.products'}">
                <div class="flex items-center py-2 px-3">
                    <span class="mr-2 ">
                        <ShoppingBagIcon class="w-6"/>
                    </span>
                    <span>
                       Products
                    </span>
                </div>
            </RouterLink>
        </li>
        <li>
            <RouterLink :to="{name : 'app.products'}">
                <div class="flex items-center py-2 px-3">
                    <span class="mr-2 ">
                        <UserIcon class="w-6"/>
                    </span>
                    <span>
                       User
                    </span>
                </div>
            </RouterLink>
        </li>
        <li>
            <RouterLink :to="{name : 'app.products'}">
                <div class="flex items-center py-2 px-3">
                    <span class="mr-2 ">
                        <EnvelopeIcon class="w-6"/>
                    </span>
                    <span>
                       Report
                    </span>
                </div>
            </RouterLink>
        </li>

    </ul>
</template>

<script setup>
import {HomeIcon, ShoppingBagIcon, UserIcon, EnvelopeIcon} from "@heroicons/vue/16/solid/index.js";

</script>

<style scoped>
</style>
