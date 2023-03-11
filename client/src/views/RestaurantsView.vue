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
                <RestaurantComponent v-for="restaurant in displayedRestaurants" :key="restaurant.id"
                    :restaurant="restaurant" />
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                        <a class="page-link" href="#" @click.prevent="currentPage--">Previous</a>
                    </li>
                    <li class="page-item" v-for="page in pages" :key="page" :class="{ active: page === currentPage }">
                        <a class="page-link" href="#" @click.prevent="currentPage = page">{{ page }}</a>
                    </li>
                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                        <a class="page-link" href="#" @click.prevent="currentPage++">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import SearchSection from "../components/SearchSection.vue";
import RestaurantComponent from "../components/Restaurant.vue";
import axios from "./../utils/axios";
import Restaurant from "./../interfaces/Restaurant";

// VARIABLES
const restaurants = ref<Restaurant[]>([]);
const currentPage = ref(1);
const itemsPerPage = 6;

// COMPUTED PROPERTIES
const totalPages = computed(() => {
    return Math.ceil(restaurants.value.length / itemsPerPage);
});

const displayedRestaurants = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return restaurants.value.slice(start, end);
});

const pages = computed(() => {
    const pagesArray = [];
    for (let i = 1; i <= totalPages.value; i++) {
        pagesArray.push(i);
    }
    return pagesArray;
});

// METHODS
onMounted(() => {
    fetchRestaurants();
});

async function fetchRestaurants() {
    const response = await axios.get("/restaurants");
    restaurants.value = response.data;
    console.log(restaurants.value);
}
</script>
<style scoped></style>