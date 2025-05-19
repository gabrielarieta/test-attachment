import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import { createPinia } from 'pinia'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.css';

const pinia = createPinia()

createApp(App)
    .use(store)
    .use(router)
    .use(pinia)
    .mount('#app')
