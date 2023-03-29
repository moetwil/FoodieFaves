<template>
  <nav class="navbar navbar-expand-lg sticky bg-white navbar-light">
    <div class="container">
      <router-link to="/" class="nav-link" active-class="active navbar-brand">FoodieFaves</router-link>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
          </li>
          <li class="nav-item">
            <router-link to="/restaurants" class="nav-link" active-class="active">
              <font-awesome-icon icon="fa-solid fa-utensils" />
              Restaurants</router-link>
          </li>
          <li v-if="isRestaurantOwner" class="nav-item">
            <router-link to="/mijn-restaurants" class="nav-link" active-class="active">
              <font-awesome-icon icon="fa-solid fa-building" />
              Mijn restaurants</router-link>
          </li>
          <li v-if="isLoggedIn" class="nav-item">
            <router-link to="/mijn-account" class="nav-link" active-class="active">
              <font-awesome-icon icon="fa-solid fa-user" />
              Mijn account</router-link>
          </li>
          <li class="nav-item">
            <button v-if="!isLoggedIn" class="nav-link btn btn-primary" @click="goToLogin">Inloggen</button>
            <button v-if="isLoggedIn" class="nav-link btn btn-primary" @click="logout">Uitloggen</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { defineComponent, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthenticationStore } from '../stores/authenticationStore';

// VARIABLES
const authenticationStore = useAuthenticationStore();
const router = useRouter();


const isLoggedIn = computed(() => authenticationStore.getIsLoggedIn);
const isRestaurantOwner = computed(() => authenticationStore.getIsRestaurantOwner);

function goToLogin() {
  router.push('/login');
}

function logout() {
  const res = authenticationStore.logout();
}
</script>

<style>
.nav-link {
  font-size: 17px;
  font-weight: 600;
  color: #000 !important;
  padding-left: 20px !important;
  padding-right: 20px !important;
}

.navbar-brand {
  font-size: 25px !important;
  padding-left: 0px !important;
}

@media (max-width: 992px) {
  .navbar-nav {
    margin-top: 10px;
  }

  .nav-item {
    text-align: center;
    margin-bottom: 10px;
  }

  .nav-link {
    padding: 10px 0;
    font-size: 16px;
    font-weight: 500;
  }

  .navbar-toggler {
    margin: 5px;
  }

  /* hamburger black */


  /* remove the grey border around the hamburger menu */
  .navbar-light .navbar-toggler {
    color: black;
    border: none;
    border: none;
  }
}
</style>
