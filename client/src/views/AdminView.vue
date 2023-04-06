<template>
    <Banner page-title="Admin panel" />
    <div class="container">
        <div class="row">
            <ManageReview v-if="flaggedReviews.length !== 0" v-for="review in flaggedReviews" :review="review"
                @reload="reloadReviews" />
            <div v-else class="col-12 text-center py-5">
                <h3>Er zijn geen reviews die beheerd moeten worden.</h3>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import Banner from './../components/Banner.vue';
import ManageReview from './../components/admin/ManageReview.vue';
import axios from './../utils/axios';

const flaggedReviews = ref([]);

onMounted(() => {
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