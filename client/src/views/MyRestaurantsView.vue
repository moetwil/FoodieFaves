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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Afbeelding</th>
                                <th scope="col">Restaurant</th>
                                <th scope="col">Adres</th>
                                <th scope="col">Postcode</th>
                                <th scope="col">City</th>
                                <!-- <th scope="col">Bewerk</th>
                                <th scope="col">Beheer reviews</th>
                                <th scope="col">Verwijder</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="restaurant in restaurants" :key="restaurant.id">
                                <td><img :src="'data:image/png;base64,' + restaurant.profile_picture" /></td>
                                <td>{{ restaurant.name }}</td>
                                <td>{{ restaurant.street }} {{ restaurant.house_number }}</td>
                                <td>{{ restaurant.zip_code }}</td>
                                <td>{{ restaurant.city }}</td>
                                <td><font-awesome-icon class="action" icon="fa-solid fa-pen-to-square" /></td>
                                <td><font-awesome-icon class="action" icon="fa-solid fa-quote-left" /></td>
                                <td><font-awesome-icon class="action" @click="handleDelete(restaurant)"
                                        icon="fa-solid fa-trash" /></td>
                            </tr>
                        </tbody>
                    </table>
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

// VARIABLES
const restaurants = ref<Restaurant[]>([]);

// METHODS

async function handleDelete(restaurant: Restaurant) {
    const confirmRes = confirm(`Weet je zeker dat je restaurant: ${restaurant.name} wilt verwijderen?`);
    if (!confirmRes) return;
    await axios.delete(`/restaurants/${restaurant.id}`);
    fetchRestaurants();
}

onMounted(() => {
    fetchRestaurants();
});

async function fetchRestaurants() {
    const response = await axios.get(`/restaurants/owner/${localStorage.getItem("user_id")}`);
    restaurants.value = response.data;
    console.log(restaurants.value);
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