<template>
    <div class="bg-light py-5">
        <div class="container ">
            <h2>Recent toegevoegde reviews</h2>
            <div class="review-list row">
                <ul>
                    <ReviewComponent v-for="review in reviews" :key="review.id" :review="review" />
                </ul>
            </div>



        </div>
    </div>
</template>

<script setup lang="ts">
import axios from './../../utils/axios';
import ReviewComponent from "../home/Review.vue";
import { onMounted, ref } from "vue";
import RestaurantComponent from "../home/Restaurant.vue";
import Review from "./../../interfaces/Review";

const reviews = ref<Review[]>([]);

// on mounted fetch reviews
onMounted(() => {
    fetchReviews();
});

async function fetchReviews() {
    try {
        const response = await axios.get(`/reviews/restaurant/2`);
        const data = response.data;

        // set max 3 reviews
        if (data.length > 3) data.length = 3;

        reviews.value = data;
    } catch (error) {
        console.error(error);
    }
}
</script>


<style scoped></style>