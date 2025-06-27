import { createApp } from 'vue'
import App from './App.vue'
import './style.css'
import store from "./store/index.js";
import router from "./router/index.js";
import PrimeVue from 'primevue/config';

createApp(App)
    .use(store)
    .use(router)
    .use(PrimeVue)
    .mount('#app')


