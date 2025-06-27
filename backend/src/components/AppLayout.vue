<template>
    <div class="min-h-full flex bg-gray-200" v-if="currentUser.id">
        <SideBar :class="{'-ml-[225px]' : !sidebarOpen }"/>
        <div class="flex-1">
            <header class=" shadow bg-white">
                <TopHeader @toggle-sidebar="toggleSidebar"/>
            </header>
            <!--Content-->
            <main class="p-6  ">
                    <router-view ></router-view>
            </main>
            <!--            Content-->
        </div>
    </div>
</template>
<script setup>

import {ref, onMounted, onUnmounted, computed} from "vue";

import SideBar from "./SideBar.vue";
import TopHeader from "./TopHeader.vue";
import store from "../store/index.js";

const sidebarOpen = ref(true);
function toggleSidebar(){
    sidebarOpen.value = !sidebarOpen.value;
}

const currentUser = computed(() => store.state.user.data)
onMounted(() => {
    store.dispatch('getUser')
        .then(() => {
            console.log('User fetched successfully');
        })
        .catch((error) => {
            console.error('Error fetching user:', error);
        });
    handleSidebarOpen();
    window.addEventListener('resize' , handleSidebarOpen);
});

onUnmounted(() => {
    window.removeEventListener('resize' , handleSidebarOpen);
});
function handleSidebarOpen() {
    sidebarOpen.value = window.outerWidth > 768;
}
</script>

<style scoped>

</style>
