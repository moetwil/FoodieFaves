<template>
  <section>
    <div class="container">
      <form ref="form">
        <h2 class="mt-3 mt-lg-5">Create a product</h2>
        <h5 class="mb-4"></h5>

        <div class="input-group mb-3">
          <span class="input-group-text">Name</span>
          <input type="text" class="form-control" v-model="product.name" />
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Price</span>
          <input type="number" class="form-control" v-model="product.price" />
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Description</span>
          <textarea class="form-control" v-model="product.description"></textarea>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Image URL</span>
          <input type="text" class="form-control" v-model="product.image" />
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Category</span>
          <select class="form-select">
            <option value="testoptionvalue">test option</option>
          </select>
        </div>

        <div class="input-group mt-4">
          <button type="button" class="btn btn-primary">Create product</button>
          <button type="button" class="btn btn-danger" @click="cancelRoute">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const product = ref({
  id: 0,
  name: "",
  price: 0.0,
  description: "",
  image: "",
  category_id: 0,
});

const categories = ref([]);

function cancelRoute(){
  router.push('/products');
}

</script>

<style></style>