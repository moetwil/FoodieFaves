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
                                <td>{{ review.food_rating }}/5</td>
                                <td>{{ review.service_rating }}/5</td>
                                <td>{{ review.price_value_rating }}/5</td>
                                <td>{{ review.review_text }}</td>
                                <td>{{ review.date }}</td>
                                <td v-if="!review.flagged"><font-awesome-icon class="flag" @click="handleFlag(review)"
                                        :icon="['fas', 'flag']" /></td>
                                <td v-else><font-awesome-icon class="flag" @click="handleUnflag(review)"
                                        :icon="['fas', 'flag']" style="color: #ff0000;" />
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
import { useAuthenticationStore } from "../stores/AuthenticationStore";
import router from "../router";

const authenticationStore = useAuthenticationStore();
// VARIABLES
const reviews = ref<Review[]>([]);
const restaurant = ref<Restaurant>({} as Restaurant);
const ownerId = ref<number | null>(null);


// METHODS

onMounted(() => {
    authenticationStore.checkAuth();
    fetchRestaurant();

    // check if user is owner of restaurant
    if (authenticationStore.user?.id !== ownerId.value) {
        router.push('/mijn-restaurants');
    }

    fetchReviews();
});

async function handleFlag(review: Review) {
    try {
        await axios.put(`/reviews/${review.id}/flag`);
        await fetchReviews();
    } catch (e) {
        console.log(e);
    }

}

async function handleUnflag(review: Review) {
    try {
        await axios.put(`/reviews/${review.id}/unflag`);
        await fetchReviews();
    } catch (e) {
        console.log(e);
    }
}

async function fetchRestaurant() {
    try {
        // get restaurant id from url
        const restaurantId = router.currentRoute.value.params.id;
        const response = await axios.get(`/restaurants/${restaurantId}`);
        restaurant.value = response.data;
        ownerId.value = response.data.owner_id;
    }
    catch (e) {
        console.log(e);
    }

}

async function fetchReviews() {
    try {
        // get restaurant id from url
        const restaurantId = router.currentRoute.value.params.id;
        const response = await axios.get(`/reviews/restaurant/${restaurantId}`);
        reviews.value = response.data;
    }
    catch (e) {
        console.log(e);
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

.flag:hover {
    cursor: pointer !important;
}
</style>