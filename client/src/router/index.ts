import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/HomeView.vue';
import Login from '../views/LoginView.vue';
import Register from '../views/RegisterView.vue';
import MyAccount from '../views/MyAccountView.vue';
import MyRestaurants from '../views/MyRestaurantsView.vue';
import MyRestaurantReviews from '../views/MyRestaurantReviewsView.vue';
import CreateRestaurant from '../views/CreateRestaurantView.vue';
import EditRestaurant from '../views/EditRestaurantView.vue';
import WriteReview from '../views/WriteReviewView.vue';
import Restaurant from '../views/RestaurantView.vue';
import Restaurants from '../views/RestaurantsView.vue';
import errorView from '../views/404View.vue';
import AdminView from '../views/AdminView.vue';
import PrivacyPolcyView from '../views/PrivacyPolicyView.vue';

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
    path: '/admin',
    component: AdminView,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/mijn-restaurants',
    component: MyRestaurants,
    meta: { requiresAuth: true, requiresRestaurantOwner: true },
  },
  {
    path: '/restaurant-aanmaken',
    component: CreateRestaurant,
    meta: { requiresAuth: true, requiresRestaurantOwner: true },
  },
  {
    path: '/restaurant-bewerken/:id?',
    component: EditRestaurant,
    meta: { requiresAuth: true, requiresRestaurantOwner: true },
  },
  {
    path: '/restaurant-reviews/:id?',
    component: MyRestaurantReviews,
    meta: { requiresAuth: true, requiresRestaurantOwner: true },
  },
  {
    path: '/write-review/:id?',
    component: WriteReview,
    meta: { requiresAuth: true },
  },
  { path: '/restaurant/:id', component: Restaurant },
  { path: '/restaurants', component: Restaurants },
  { path: '/privacy-policy', component: PrivacyPolcyView },
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
  } else if (to.meta.requiresAdmin && !isLoggedIn) {
    next('/');
  } else if (to.path === '/register' && isLoggedIn) {
    next('/');
  } else {
    next();
  }
});

export default router;
