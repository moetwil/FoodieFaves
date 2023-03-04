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
import axios from "./../../utils/axios";

const restaurants = ref<Restaurant[]>([]);

// on mounted fetch restaurants
onMounted(() => {
    fetchRestaurants();
});

async function fetchRestaurants() {
    try {
        const response = await axios.get("/restaurants");
        restaurants.value = response.data;
    } catch (error) {
        console.log(error);
    }
}
</script>


<style scoped></style>