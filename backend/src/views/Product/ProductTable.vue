<script>
import store from "../../store/index.js";

export default {
    name: "ProductTable"
}

</script>

<script setup>

import {computed, onMounted, ref} from "vue";
import {PRODUCTS_PER_PAGE} from "../../constants.js";
import TableHeadingCell from "../../components/core/table/TableHeadingCell.vue";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue"
import {ListBulletIcon, PencilIcon, TrashIcon} from '@heroicons/vue/24/solid'

const perPage = ref(PRODUCTS_PER_PAGE)
const search = ref('')
const products = computed(() => store.state.products)
const sortField = ref('updated_at')
const sortDirection = ref('desc')

const emit = defineEmits(['clickEdit'])

onMounted(() => {
    getProducts();
})


function getProducts(url = null) {
    store.dispatch('getProducts', {
        url,
        sort_field: sortField.value,
        sort_direction: sortDirection.value,
        search: search.value,
        perPage: perPage.value
    })
}

function getForPage(ev, link) {
    ev.preventDefault();
    if (!link.url || link.active) {
        return;
    }
    getProducts(link.url)
}

function sortProduct(field) {
    if (sortField.value === field) {
        if (sortDirection.value === 'asc') {
            sortDirection.value = 'desc'
        } else {
            sortDirection.value = 'asc'
        }
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }
    getProducts();
}

function deleteProduct(product) {
    console.log('Attempting to delete product:', product); // Log the product being deleted

    if (!confirm(`Are you sure you want to delete the product?`)) {
        console.log('Delete action canceled by the user.');
        return;
    }

    store.dispatch('deleteProduct', product.id)
        .then(() => {
            console.log('Product deleted successfully:', product.id); // Log success
            store.dispatch('getProducts'); // Re-fetch products
        })
        .catch((error) => {
            console.error('Failed to delete product:', error); // Log error
            alert('An error occurred while deleting the product. Please try again.');
        });
}

function editProducts(product) {
    emit('clickEdit', product)
}
</script>

<template>
    <div class="bg-white p-4 rounded-lg shadow ">
        <div class=" flex items-center gap-2">
            <span class="whitespace-nowrap mr-3 ">
                Per page
            </span>
            <select @change="getProducts(null)" v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <div>
                <input
                    v-model="search"
                    @change="getProducts(null)"
                    class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Type to Search products"
                >
            </div>
        </div>
        <table class="table-auto w-full">
            <thead>
            <tr>
                <TableHeadingCell @click="sortProduct('id')" class="border-b-2 p-2 text-left" field="id"
                                  :sort-field="sortField" :sort-direction="sortDirection">ID
                </TableHeadingCell>
                <TableHeadingCell @click="sortProduct('image')" class="border-b-2 p-2 text-left" field=""
                                  :sort-field="sortField"
                                  :sort-direction="sortDirection">Image
                </TableHeadingCell>
                <TableHeadingCell @click="sortProduct('title')" class="border-b-2 p-2 text-left" field="title"
                                  :sort-field="sortField" :sort-direction="sortDirection">Title
                </TableHeadingCell>
                <TableHeadingCell @click="sortProduct('price')" class="border-b-2 p-2 text-left" field="price"
                                  :sort-field="sortField" :sort-direction="sortDirection">Price
                </TableHeadingCell>
                <TableHeadingCell @click="sortProduct('updated_at')" class="border-b-2 p-2 text-left" field="updated_at"
                                  :sort-field="sortField" :sort-direction="sortDirection">Last Updated At
                </TableHeadingCell>
                <TableHeadingCell field="action">
                    Action
                </TableHeadingCell>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product , index ) of products.data">
                <td class="border-b p-2"> {{ product.id }}</td>
                <td class="border-b p-2">
                    <img :src="product.image_url" :alt="product.name" class="w-24 h-24">
                </td>
                <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
                    {{ product.name }}
                </td>
                <td class="border-b p-2"> {{ product.price }}</td>
                <td class="border-b p-2"> {{ product.updated_at }}</td>
                <td class="border-b p-2">
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="inline-flex items-center  w-full justify-center rounded-full  h-10 bg-block bg-opacity-0"
                            >
                                <ListBulletIcon
                                    class="h-5 w-5 text-indigo-500"
                                    aria-hidden="true"
                                />

                            </MenuButton>
                        </div>
                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ">
                                <div
                                    class="px-1 py-1">
                                    <MenuItem v-slot="{ active }">
                                        <button
                                            :class="[
                                                active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                ]"
                                            @click="editProducts(product)"
                                        >
                                            <PencilIcon
                                                :active="active"
                                                class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true"
                                            />
                                            Edit
                                        </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <button
                                            :class="[
                                            active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                          ]"
                                            @click="deleteProduct(product)"
                                        >
                                            <TrashIcon
                                                :active="active"
                                                class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true"
                                            />
                                            Delete
                                        </button>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="flex justify-between items-center mt-5">
            <span>
                showing from {{ products.from }} to {{ products.to }}
            </span>
            <nav
                v-if="products.total > products.limit"
                class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                aria-label="Pagination"
            >
                <a
                    v-for="(link, i) of products.links"
                    :key="i"
                    :disabled="!link.url"
                    href="#"
                    @click="getForPage($event, link)"
                    aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                    :class="[
                      link.active
                        ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                      i === 0 ? 'rounded-l-md' : '',
                      i === products.links.length - 1 ? 'rounded-r-md' : '',
                      !link.url ? ' bg-gray-100 text-gray-700': ''
                    ]"
                    v-html="link.label"
                >
                </a>
            </nav>
        </div>
    </div>
</template>

<style scoped>

</style>
