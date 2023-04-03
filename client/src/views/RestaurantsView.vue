<template>
    <div>
        <SearchSection />
        <div class="container">
            <div class="row">
                <div class="col-12 py-3">
                    <h1 class="text-center">Restaurants</h1>
                    <div class="col-12">
                        <div class="btn-group" role="group" aria-label="Restaurant Types">
                            <button class="btn btn-outline-secondary" @click="fetchRestaurants()">All</button>
                            <button v-for="(type, index) in restaurantTypes" :key="index" class="btn btn-outline-secondary"
                                @click="fetchRestaurantsByType(type)">{{ type.name }}</button>
                        </div>
                    </div>
                </div>
                <RestaurantComponent v-for="(restaurant, index) in restaurants" :key="index" :restaurant="restaurant"
                    @click="goToRestaurant(restaurant)" />
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, onMounted } from "vue";
import SearchSection from "../components/SearchSection.vue";
import RestaurantComponent from "../components/Restaurant.vue";
import axios from "./../utils/axios";
import Restaurant from "./../interfaces/Restaurant";
import RestaurantType from "./../interfaces/RestaurantType";
import { useRouter } from "vue-router";


// VARIABLES
const restaurants = ref<Restaurant[]>([]);
const router = useRouter();
const restaurantTypes = ref<RestaurantType[]>([]);

// METHODS
function goToRestaurant(restaurant: Restaurant) {
    router.push(`/restaurant/${restaurant.id}`);
}

onMounted(() => {
    fetchRestaurants();
    fetchRestaurantTypes();
});

async function fetchRestaurants() {
    try {
        const response = await axios.get("/restaurants");
        restaurants.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

async function fetchRestaurantTypes() {
    try {
        const response = await axios.get("/restaurant-types");
        restaurantTypes.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

async function fetchRestaurantsByType(type: RestaurantType) {
    try {
        const response = await axios.get(`/restaurants?type=${type.id}`);
        restaurants.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

</script>
<style scoped></style>