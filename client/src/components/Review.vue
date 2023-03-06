<template>
    <div class="col-md-6">
        <li class="card py-3 px-3 col my-3">
            <div class="d-flex">
                <div class="left px-3">
                    <span>
                        <img v-if="user && user.profile_picture" :src="'data:image/png;base64,' + user.profile_picture"
                            class="profile-pict-img img-fluid" alt="" />

                    </span>
                </div>
                <div class="right">
                    <h4>
                        {{ fullName }}
                        <span class="gig-rating text-body-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792" width="25" height="25">
                                <path fill="#ffbf00"
                                    d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z">
                                </path>
                            </svg>
                            {{ averageRating }}/5
                        </span>
                    </h4>
                    <div class="review-description">
                        <p>
                            {{ review.review_text }}
                        </p>

                        <div class="rating d-flex justify-content-center flex-column mt-2">
                            <span class="text-body-3">Eten: {{ review.food_rating }}</span>
                            <span class="text-body-3">Bediening: {{ review.service_rating }}</span>
                            <span class="text-body-3">Prijs-kwaliteit: {{ review.price_value_rating }}</span>
                        </div>

                    </div>
                    <span class="publish py-3 d-inline-block w-100">Published: {{ review.date }}</span>
                </div>
            </div>
        </li>
    </div>
</template>

<script setup lang="ts">
import { onMounted, PropType, ref, computed } from 'vue';
import Review from "../interfaces/Review";
import User from "../interfaces/User";
import axios from "../utils/axios";

// VARIABLES
const user = ref<User>();
const { review } = defineProps({
    review: {
        type: Object as PropType<Review>,
        required: true
    }
})

// COMPUTED
const fullName = computed(() => {
    return user.value?.first_name + " " + user.value?.last_name;
})

const averageRating = computed(() => {
    const rating = (review.food_rating + review.service_rating + review.price_value_rating) / 3;
    return rating % 1 === 0 ? rating : rating.toFixed(1);
});

// GET DATA
onMounted(() => {
    fetchUser();
});

async function fetchUser() {
    try {
        const response = await axios.get(`users/${review.user_id}`);
        user.value = response.data;
    } catch (error) {
        console.error(error);
    }
}
</script>


<style scoped>
body {
    margin-top: 20px;
    background: #eee;
}

.text-body-3 {
    font-size: 14px;
}

.review-list ul li .left span {
    width: 32px;
    height: 32px;
    display: inline-block;
}

.review-list ul li .left {
    flex: none;
    max-width: none;
    margin: 0 10px 0 0;
}

.review-list ul li .left span img {
    border-radius: 50%;
}

.review-list ul li .right h4 {
    font-size: 16px;
    margin: 0;
    display: flex;
}

.review-list ul li .right h4 .gig-rating {
    display: flex;
    align-items: center;
    margin-left: 10px;
    color: #ffbf00;
}

.review-list ul li .right h4 .gig-rating svg {
    margin: 0 4px 0 0px;
}


.review-list ul li .right {
    flex: auto;
}

.review-list ul li .review-description {
    margin: 20px 0 0;
}

.review-list ul li .review-description p {
    font-size: 17px;
    margin: 0;
}

.review-list ul li .publish {
    font-size: 13px;
    color: #95979d;
}

ul,
ul li {
    list-style: none;
    margin: 0px;
}

.helpful-thumbs,
.helpful-thumb {
    display: flex;
    align-items: center;
    font-weight: 700;
}

.card {
    /* border: none !important; */
}

img {
    width: 200px;
    height: auto;
}
</style>