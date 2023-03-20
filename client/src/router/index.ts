import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/HomeView.vue';
import Login from '../views/LoginView.vue';
import Register from '../views/RegisterView.vue';
import MyAccount from '../views/MyAccountView.vue';
import MyRestaurants from '../views/MyRestaurantsView.vue';
import WriteReview from '../views/WriteReviewView.vue';
import Restaurant from '../views/RestaurantView.vue';
import Restaurants from '../views/RestaurantsView.vue';
import errorView from '../views/404View.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  {
    path: '/mijn-account',
    component: MyAccount,
    meta: { requiresAuth: true },
  },
  {
    path: '/mijn-restaurants',
    component: MyRestaurants,
    meta: { requiresAuth: true, requiresRestaurantOwner: true },
  },
  {
    path: '/write-review/:id?',
    component: WriteReview,
    meta: { requiresAuth: true },
  },
  { path: '/restaurant/:id', component: Restaurant },
  { path: '/restaurants', component: Restaurants },
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
  const userRole = localStorage.getItem('user_type');

  if (to.meta.requiresAuth && !isLoggedIn) {
    next('/login');
  } else if (
    to.meta.requiresRestaurantOwner &&
    (!isLoggedIn || userRole !== '1')
  ) {
    next('/');
  } else {
    next();
  }
});

export default router;
