import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/HomeView.vue';
import Login from '../views/LoginView.vue';
import WriteReview from '../views/WriteReviewView.vue';
import Restaurant from '../views/RestaurantView.vue';
import errorView from '../views/404View.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  {
    path: '/write-review/:id?',
    component: WriteReview,
    meta: { requiresAuth: true },
  },
  { path: '/restaurant/:id', component: Restaurant },
  // create a 404 page
  { path: '/:pathMatch(.*)*', component: errorView },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

// Check if user is logged in before each route change
router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('token') !== null;

  if (to.meta.requiresAuth && !isLoggedIn) {
    next('/login');
  } else {
    next();
  }
});

export default router;
