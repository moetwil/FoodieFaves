<script setup lang="ts">
import { onMounted } from 'vue';
import Navigation from './components/Navigation.vue';
import Footer from './components/Footer.vue';
import { useAuthenticationStore } from './stores/AuthenticationStore';

const authenticationStore = useAuthenticationStore();

onMounted(() => {
  authenticationStore.checkAuth();

});

</script>

<template>
  <Navigation />
  <RouterView />
  <Footer />
</template>

<style scoped></style>
