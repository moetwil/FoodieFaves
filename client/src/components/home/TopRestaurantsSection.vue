<template>
    <div class="container mt-5 mb-5">
        <div class="row">
            <h2>
                Recent toegevoegde restaurants
            </h2>
        </div>
        <div class="row">
            <RestaurantComponent @click="goToRestaurant(restaurant)" v-for="restaurant in restaurants" :key="restaurant.id"
                :restaurant="restaurant" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import RestaurantComponent from "../Restaurant.vue";
import Restaurant from "./../../interfaces/Restaurant";
import axios from "./../../utils/axios";
import { useRouter } from "vue-router";

const router = useRouter();
const restaurants = ref<Restaurant[]>([]);

// on mounted fetch restaurants
onMounted(() => {
    fetchRestaurants();
});

function goToRestaurant(restaurant: Restaurant) {
    router.push(`/restaurant/${restaurant.id}`);
}

async function fetchRestaurants() {
    try {
        const response = await axios.get("/restaurants?limit=3&order=DESC");
        restaurants.value = response.data;
    } catch (error) {
        console.log(error);
    }
}
</script>


<style scoped></style>