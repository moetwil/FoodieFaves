<template>
    <div>
        <Banner :page-title="'Reviews van ' + restaurant.name" />
        <div class="container">
            <div class="mt-5 row d-flex justify-content-center">
                <div class="col">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Afbeelding</th>
                                <th scope="col">Eten</th>
                                <th scope="col">Service</th>
                                <th scope="col">Prijs/kwaliteit</th>
                                <th scope="col">Review</th>
                                <th scope="col">Datum</th>
                                <th scope="col">Datum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(review, index) in reviews" :key="index">
                                <td><img v-if="review && review.image" :src="review.image" alt="" /></td>
                                <td>{{ review.food_rating }}</td>
                                <td>{{ review.service_rating }}</td>
                                <td>{{ review.price_value_rating }}</td>
                                <td>{{ review.review_text }}</td>
                                <td>{{ review.date }}</td>
                                <td><font-awesome-icon class="action" :icon="['fas', 'flag']" style="color: #ff0000;" />
                                </td>
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
import Review from "./../interfaces/Review";
import Restaurant from "./../interfaces/Restaurant";
import { useAuthenticationStore } from "../stores/authenticationStore";
import router from "../router";

const authenticationStore = useAuthenticationStore();
// VARIABLES
const reviews = ref<Review[]>([]);
const restaurant = ref<Restaurant>({} as Restaurant);
const ownerId = ref<number | null>(null);


// METHODS
function handleFlag(review: Review) {
    console.log('flagged');
}

onMounted(async () => {
    await authenticationStore.checkAuth();
    await fetchRestaurant();

    // check if user is owner of restaurant
    if (authenticationStore.user?.id !== ownerId.value) {
        router.push('/mijn-restaurants');
    }

    await fetchReviews();
});

async function fetchRestaurant() {
    // get restaurant id from url
    const restaurantId = router.currentRoute.value.params.id;
    const response = await axios.get(`/restaurants/${restaurantId}`);
    restaurant.value = response.data;
    ownerId.value = response.data.owner_id;
    console.log(restaurant.value);
}

async function fetchReviews() {
    const restaurantId = router.currentRoute.value.params.id;
    const response = await axios.get(`/reviews/restaurant/${restaurantId}`);
    reviews.value = response.data;
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