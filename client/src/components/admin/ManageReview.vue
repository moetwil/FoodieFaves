<template>
    <div class="col-md-12">
        <li class="card py-3 px-3 col my-3">
            <!-- review header -->
            <div class="row d-flex justify-content-between">
                <div class="col-md-2 d-flex justify-content-between align-items-center flex-row px-3">
                    <img v-if="user && user.profile_picture" :src="user.profile_picture" class="profile-pict-img img-fluid"
                        alt="" />
                    <h4>{{ fullName }}</h4>
                </div>
                <div class="col-md-4" id="manage-review-controls">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success mx-3" @click="handleApprove">Approve</button>
                        <button type="button" class="btn btn-danger" @click="handleDelete">Delete</button>
                    </div>
                </div>
            </div>
            <!-- review content -->
            <div class="row">
                <div class="col-md-12 mt-4">
                    <h4>
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
                    <div class="review-image review-image-container" v-if="review.image">
                        <img :src="review.image" alt="" class="review-image">
                    </div>

                    <span class="publish py-3 d-inline-block w-100">Published: {{ review.date }}</span>
                </div>
            </div>
        </li>
    </div>
</template>

<script setup lang="ts">
import { onMounted, PropType, ref, computed } from 'vue';
import Review from "../../interfaces/Review";
import User from "../../interfaces/User";
import axios from "../../utils/axios";

// VARIABLES
const user = ref<User>();
const { review } = defineProps({
    review: {
        type: Object as PropType<Review>,
        required: true
    }
})

const emits = defineEmits(['reload']);


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

async function handleApprove() {
    try {
        const response = await axios.put(`reviews/${review.id}/approve`, {});

        if (response.status === 200) {
            emits('reload');

        }
    } catch (error) {
        console.error(error);
    }

}

async function handleDelete() {
    try {
        const response = await axios.delete(`reviews/${review.id}`);

        if (response.status === 200) {
            emits('reload');
        }
    } catch (error) {
        console.error(error);
    }

}

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

ul,
ul li {
    list-style: none;
    margin: 0px;
}

.profile-pict-img {
    width: 50px;
    height: 50px;
}

.review-image-container {
    width: 100px;
    height: auto;
    margin: 10px 0;
    position: relative;
}

.review-image {
    max-width: 100%;
    max-height: 100%;
}
</style>