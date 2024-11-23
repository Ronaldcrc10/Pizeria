import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

const routes = [
    { path: '/', component: Pedidos },
  ];
  
  const routes = createRouter({
    history: createWebHistory(),
    routes,
  });
  
  const routes = [
      { path: '/', component: Clientes },
    ];
    
    const router = createRouter({
      history: createWebHistory(),
      routes,
    });

createApp(App).use(router).mount('#app');
