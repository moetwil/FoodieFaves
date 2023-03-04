<template>
    <div class="container mt-5 mb-5">
        <div class="row">
            <h2>
                Recent toegevoegde restaurants
            </h2>
        </div>
        <div class="row">
            <RestaurantComponent v-for="restaurant in restaurants" :key="restaurant.id" :restaurant="restaurant" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import RestaurantComponent from "../home/Restaurant.vue";
import Restaurant from "./../../interfaces/Restaurant";

// const restaurants = ref([]);
const restaurants = ref<Restaurant[]>([]);

// on mounted fetch restaurants
onMounted(() => {
    fetchRestaurants();
});

async function fetchRestaurants() {
    const response = await fetch("http://localhost/api/restaurants");
    const data = await response.json();

    restaurants.value = data;

}


</script>

<style scoped></style>