<template>
    <div class="bg-light py-5">
        <div class="container ">
            <h2>Recent toegevoegde reviews</h2>
            <div class="row bg-light">
                <ReviewComponent v-for="(review, index) in reviews" :key="index" :review="review" />
            </div>



        </div>
    </div>
</template>

<script setup lang="ts">
import axios from './../../utils/axios';
import ReviewComponent from "../Review.vue";
import { onMounted, ref } from "vue";
import RestaurantComponent from "../Restaurant.vue";
import Review from "./../../interfaces/Review";

const reviews = ref<Review[]>([]);

// on mounted fetch reviews
onMounted(() => {
    fetchReviews();
});

async function fetchReviews() {
    try {
        const response = await axios.get(`/reviews?limit=2&order=DESC`);
        reviews.value = response.data;
    } catch (error) {
        console.error(error);
    }
}
</script>


<style scoped></style>