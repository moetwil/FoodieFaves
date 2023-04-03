<template>
    <div>
        <Banner page-title="Mijn restaurants" />
        <div class="container">
            <div class="row mt-5">
                <div class="col d-flex justify-content-end">
                    <router-link to="/restaurant-aanmaken"><button class="button btn-secondary py-2">+ Restaurant
                            toevoegen</button>
                    </router-link>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Afbeelding</th>
                                    <th scope="col">Restaurant</th>
                                    <th scope="col">Adres</th>
                                    <th scope="col">Postcode</th>
                                    <th scope="col">Stad</th>
                                    <th scope="col">Bewerk</th>
                                    <th scope="col">Beheer reviews</th>
                                    <th scope="col">Verwijder</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(restaurant, index) in restaurants" :key="index">
                                    <td><img v-if="restaurant && restaurant.profile_picture"
                                            :src="restaurant.profile_picture" alt="" /></td>
                                    <td>{{ restaurant.name }}</td>
                                    <td>{{ restaurant.street }} {{ restaurant.house_number }}</td>
                                    <td>{{ restaurant.zip_code }}</td>
                                    <td>{{ restaurant.city }}</td>
                                    <td><font-awesome-icon class="action" @click="handleEdit(restaurant)"
                                            icon="fa-solid fa-pen-to-square" /></td>
                                    <td><font-awesome-icon class="action" @click="handleManageReviews(restaurant)"
                                            icon="fa-solid fa-quote-left" /></td>
                                    <td><font-awesome-icon class="action" @click="handleDelete(restaurant)"
                                            icon="fa-solid fa-trash" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, onMounted } from "vue";
import Banner from "../components/Banner.vue";
import axios from "./../utils/axios";
import Restaurant from "./../interfaces/Restaurant";
import router from "../router";

// VARIABLES
const restaurants = ref<Restaurant[]>([]);

// METHODS

function handleEdit(restaurant: Restaurant) {
    router.push(`/restaurant-bewerken/${restaurant.id}`);
}
function handleManageReviews(restaurant: Restaurant) {
    router.push(`/restaurant-reviews/${restaurant.id}`);
}

async function handleDelete(restaurant: Restaurant) {
    try {
        const confirmRes = confirm(`Weet je zeker dat je restaurant: ${restaurant.name} wilt verwijderen?`);
        if (!confirmRes) return;
        await axios.delete(`/restaurants/${restaurant.id}`);
        fetchRestaurants();
    } catch (error) {
        console.log(error);
    }
}

onMounted(() => {
    fetchRestaurants();
});

async function fetchRestaurants() {
    try {
        const response = await axios.get(`/restaurants/owner/${localStorage.getItem("user_id")}`);
        restaurants.value = response.data;
        console.log(restaurants.value);
    } catch (error) {
        console.log(error);
    }
}
</script>
<style scoped>
tr {
    vertical-align: middle;
}

td img {
    width: 75px;
    height: auto;
    object-fit: cover;
}

.action:hover {
    cursor: pointer !important;
}
</style>