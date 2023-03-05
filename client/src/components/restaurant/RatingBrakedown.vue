<template>
    <div class="rating-brakedown mt-5">
        <h4>Rating</h4>
        <div class="row py-1">
            <div class="col-md-6">Eten</div>
            <FiveStars :amount="restaurantStore.averageFoodRating" />
        </div>
        <div class="row py-1">
            <div class="col-md-6">Service</div>
            <FiveStars :amount="restaurantStore.averageServiceRating" />

        </div>
        <div class="row py-1">
            <div class="col-md-6">Prijs/kwaliteit</div>
            <FiveStars :amount="restaurantStore.averagePriceValueRating" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import FiveStars from './FiveStars.vue'
import { useRestaurantStore } from './../../stores/RestaurantStore';

// VARIABLES
const restaurantStore = useRestaurantStore();



</script>

<style scoped></style>