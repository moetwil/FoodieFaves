<template>
    <div>
        <SearchSection />
        <div class="container">
            <div class="row">
                <div class="col-12 py-3">
                    <h1 class="text-center">Restaurants</h1>
                </div>
                <div class="col-12">
                    <!-- Add filters options for the restaurant -->
                </div>
                <RestaurantComponent v-for="(restaurant, index) in restaurants" :key="index" :restaurant="restaurant"
                    @click="goToRestaurant(restaurant)" />
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import SearchSection from "../components/SearchSection.vue";
import RestaurantComponent from "../components/Restaurant.vue";
import axios from "./../utils/axios";
import Restaurant from "./../interfaces/Restaurant";
import { useRouter } from "vue-router";


// VARIABLES
const restaurants = ref<Restaurant[]>([]);
const router = useRouter();

// METHODS
function goToRestaurant(restaurant: Restaurant) {
    router.push(`/restaurant/${restaurant.id}`);
}

onMounted(() => {
    fetchRestaurants();
});

async function fetchRestaurants() {
    try {
        const response = await axios.get("/restaurants");
        restaurants.value = response.data;
    } catch (error) {
        console.error(error);
    }
}
</script>
<style scoped></style>