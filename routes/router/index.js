import { createRouter, createWebHistory } from 'vue-router';
import Pedidos from '../views/Pedidos.vue';

const routes = [
  { path: '/', component: Pedidos },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
