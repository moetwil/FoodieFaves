<template>
    <div class="col">
        <Star v-for="(star, index) in amount" :key="index" />
    </div>
</template>

<script setup lang="ts">
import Star from './Star.vue';

const { amount } = defineProps({
    amount: {
        type: Number,
        required: true
    }
})
</script>

<style scoped></style>