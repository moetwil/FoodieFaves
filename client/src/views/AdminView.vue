<template>
    <Banner page-title="Admin panel" />
    <div class="container">
        <div class="row">
            <ManageReview v-for="review in flaggedReviews" :review="review" @reload="reloadReviews" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import Banner from './../components/Banner.vue';
import ManageReview from './../components/admin/ManageReview.vue';
import axios from './../utils/axios';

const flaggedReviews = ref([]);

onMounted(async () => {
    fetchFlaggedReviews();
});

async function reloadReviews() {
    fetchFlaggedReviews();
}

async function fetchFlaggedReviews() {
    try {
        const response = await axios.get('reviews?order=asc&filter=flaggedAndNotApproved');
        flaggedReviews.value = response.data;
    }
    catch (error) {
        console.error(error)
    }
}


</script>

<style scoped></style>