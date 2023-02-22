<template>
    <div class="container mt-5 mb-5">
        <div class="row">
            <h2>
                Recent toegevoegde restaurants
            </h2>
        </div>
        <div class="row">
            <Restaurant />
            <Restaurant />
            <Restaurant />
        </div>
    </div>
</template>

<script setup lang="ts">
import Restaurant from "../home/Restaurant.vue";
</script>

<style scoped></style>