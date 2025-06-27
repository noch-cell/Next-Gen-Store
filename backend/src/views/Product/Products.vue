<script>
export default {
    name: "Products"
}

</script>

<script setup>

import ProductTable from "./ProductTable.vue";
import ProductModal from "./ProductModal.vue";
import {ref} from 'vue'
import store from "../../store/index.js";

const showModal = ref(false)
const DEFAULT_EMPTY_OBJECT = {
    id: '',
    name: '',
    image: '',
    description: '',
    price: '',
}
const productModel = ref({...DEFAULT_EMPTY_OBJECT})

function showProductModal() {
    showModal.value = true
}

function editProducts(product) {
    store.dispatch('getProduct', product.id)
        .then(({data}) => {
            productModel.value = data
            showProductModal()
        })
}

function onModalClose() {
    productModel.value = {...DEFAULT_EMPTY_OBJECT}
}


</script>

<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Products</h1>
        <button
            type="submit"
            @click="showProductModal"
            class=" flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add new Product
        </button>
    </div>
    <ProductModal v-model="showModal" :product="productModel" @close="onModalClose"/>
    <ProductTable @clickEdit="editProducts"/>
</template>

<style scoped>

</style>
