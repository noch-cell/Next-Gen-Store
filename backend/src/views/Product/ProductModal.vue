<script>
import store from "../../store/index.js";

export default {
    name: "ProductModal"
}

</script>

<script setup>

import {computed, onUpdated, ref} from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import CustomInput from "../../components/core/table/CustomInput.vue";
import Spinner from "../../components/core/Spinner.vue";

const loading = ref(false)
const props = defineProps({
    modelValue: Boolean,
    product: {
        required: true,
        type: Object
    }
})
const product = ref({
    id: props.product.id,
    name: props.product.name,
    image: props.product.image,
    description: props.product.description,
    price: props.product.price,
})

const emit = defineEmits(['update:modelValue'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

onUpdated(() => {
    product.value = {
        id: props.product.id,
        name: props.product.name,
        image: props.product.image,
        description: props.product.description,
        price: props.product.price,
    }
})

function closeModal() {
    show.value = false
    emit('close')
}


function onSubmit() {
    loading.value = true
    if (product.value.id) {
        store.dispatch('updateProduct', product.value)
            .then(response => {
                loading.value = false;
                if (response.status === 200) {
                    store.dispatch('getProducts')
                    closeModal()
                }
            })
    } else {
        store.dispatch('createProduct', product.value)
            .then(response => {
                loading.value = false;
                if (response.status === 201) {
                    store.dispatch('getProducts')
                    closeModal()
                }
            })
    }

}
</script>

<template>
    <TransitionRoot appear :show="show" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white  text-left align-middle shadow-xl transition-all"
                        >
                            <Spinner v-if="loading"
                                     class=" absolute left-0 top-0 right-0 bottom-0 items-center justify-center"
                            />
                            <header class="py-3 px-4 flex justify-between items-center">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    {{ product.id ? `Update Product : "${props.product.name}` : 'Add new  Product' }}
                                </DialogTitle>
                                <button
                                    @click="closeModal()"
                                    class="w-8 h-8 flex items-center justify-center rounded-full transition-color cursor-pointer hover:bg-[rgba(0.0.0.2)]"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="size-6">
                                        <path fill-rule="evenodd"
                                              d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </header>

                            <form @submit.prevent="onSubmit" action="">
                                <div class="bg-white px-4 pt-5 pb-4">
                                    <CustomInput class="mb-2 " v-model="product.name" label="Product Name"/>
                                    <CustomInput type="file" class="mb-2" v-model="product.name" label="Product Image"
                                                 @change="file => product.image = file"/>
                                    <CustomInput type="textarea" class="mb-2" v-model="product.description"
                                                 label="Description"/>
                                    <CustomInput type="number" class="mb-2" v-model="product.price" label="Price"
                                                 prepend="$"/>
                                </div>
                                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-revers">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button"
                                            class="mt-3 py-2 px-4 inline-flex justify-center w-full border  border-gray-300 text-sm  shadow-sm font-medium rounded-md text-gray-700  hover:bg-gray-50 focus:outline-none  focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                            @click="closeModal" ref="cancelButtonRef"
                                    >
                                        Cancel
                                    </button>
                                </footer>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>


<style scoped>

</style>
