import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/HomeView.vue';

const routes: any = [{ path: '/', component: Home }];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: routes,
});

export default router;
