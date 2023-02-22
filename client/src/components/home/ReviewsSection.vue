<template>
    <div class="bg-light py-5">
        <div class="container ">
            <h2>Recent toegevoegde reviews</h2>
            <div class="review-list row">
                <ul>
                    <Review />
                    <Review />
                </ul>
            </div>



        </div>
    </div>
</template>

<script setup lang="ts">
import Review from "../home/Review.vue";
</script>

<style scoped></style>