import { createRouter, createWebHistory } from 'vue-router';
import Pedidos from '../views/Pedidos.vue';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

createApp(App).use(router).mount('#app');


export default router;
