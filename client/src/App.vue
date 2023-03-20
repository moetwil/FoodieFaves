<script setup lang="ts">
import { onMounted } from 'vue';
import Navigation from './components/Navigation.vue';
import { useAuthenticationStore } from './stores/authenticationStore';

const authenticationStore = useAuthenticationStore();

onMounted(() => {
  authenticationStore.checkAuth();

});

</script>

<template>
  <navigation />
  <RouterView />
</template>

<style scoped></style>
