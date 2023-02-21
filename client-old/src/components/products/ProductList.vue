<template>
  <section>
    <div class="container">
      <h2 class="mt-3 mt-lg-5">Products</h2>
      <button type="button" class="btn btn-primary mt-3" @click="this.$router.push('/createproduct');">
        Add product
      </button>
      <div class="row mt-3">
        <product-list-item v-for="product in products" :key="product.id" :product="product" />
      </div>
    </div>
  </section>
</template>

<script setup>
import ProductListItem from "./ProductListItem.vue";
import { ref } from "vue";

const products = ref([]);
</script>

<style></style>