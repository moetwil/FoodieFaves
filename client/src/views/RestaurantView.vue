<template>
    <div>
        <Banner :page-title="pageTitle" />
        <div class="container">
            <div class="row py-3">
                <div class="col-md-3 p-3">
                    <h2>Gemiddelde Rating</h2>
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="gig-rating text-body-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792" width="50" height="50">
                                <path fill="#ffbf00"
                                    d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z">
                                </path>
                            </svg>
                        </span>
                        <h3 class="overall-rating px-3">{{ restaurantStore.getAverageRating ?
                            restaurantStore.getAverageRating :
                            'TBD' }}</h3>
                    </div>
                    <span class="based-on">Gebaseerd op {{ restaurantStore.getReviewCount }} reviews</span>
                    <RatingBrakedown />

                    <button @click="goToReview(restaurantStore.getRestaurant)" type="button"
                        class="btn-primary py-2 mt-3 ">Schrijf een review</button>
                </div>
                <div class="col-md-9 bg-light px-4 py-3">
                    <div class="row">
                        <Review v-for="(review, index) in restaurantStore.getReviews || []" :review="review" :key="index" />
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import Banner from "./../components/Banner.vue";
import RatingBrakedown from "./../components/restaurant/RatingBrakedown.vue";
import Review from "./../components/Review.vue";
import { useRestaurantStore } from '../stores/RestaurantStore';
import Restaurant from "../interfaces/Restaurant";

// VARIABLES
const restaurantStore = useRestaurantStore();
const router = useRouter();

// COMPUTED
const pageTitle = computed(() => {
    if (restaurantStore.restaurant && restaurantStore.restaurant.name) {
        document.title = `Restaurant - ${restaurantStore.restaurant.name} (${restaurantStore.restaurant.city})})`;
        return `${restaurantStore.restaurant.name} - ${restaurantStore.restaurant.city}`;
    } else {
        return "Loading...";
    }
});

function goToReview(restaurant: Restaurant | null) {
    if (restaurant) {
        router.push(`/write-review/${restaurant.id}`);
    }
    else {
        router.push(`/write-review`);
    }
}

onMounted(() => {
    // get id from url with router
    const id = router.currentRoute.value.params.id as string;

    // fetch restaurant data
    restaurantStore.fetchRestaurant(id);
    restaurantStore.fetchReviews(id);
    restaurantStore.fetchAverageRating(id);
});
</script>


<style scoped>
.overall-rating {
    font-size: 50px;
}

.based-on {
    font-size: 20px;
    font-weight: 600;
}

.btn-primary {
    background-color: #000;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
    width: 100%;
}

.btn-primary:hover {
    border: 1.5px solid #000 !important;
}
</style>