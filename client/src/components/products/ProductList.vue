<template>
  <section>
    <div class="container">
      <h2 class="mt-3 mt-lg-5">Products</h2>
      <button type="button" class="btn btn-primary mt-3" @click="redirect('/createproduct');">
        Add product
      </button>
      <div class="row mt-3">
        <product-list-item v-for="product in products" :key="product.id" :product="product" />
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import ProductListItem from "./ProductListItem.vue";

import Product from "../../interfaces/product";

const router = useRouter();

const products = ref<Product[]>([]);

function redirect(location: string){
  router.push('/' + location);
}
</script>

<style></style>