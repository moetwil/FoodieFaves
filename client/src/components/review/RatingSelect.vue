<template>
    <div class="form-group row">
        <label>{{ label }}</label>
        <div>
            <span v-for="i in 5" :key="i" @click="setRating(i)" @mouseover="highlightStars(i)" @mouseleave="resetStars">
                <i :class="{ ' fa fa-star highlighted': i <= highlightedRating }"></i>
            </span>
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps, toRef, defineEmits } from 'vue';

const emits = defineEmits(['input']);

const { label, value } = defineProps({
    label: {
        type: String,
        required: true,
    },
    value: {
        type: Number,
        required: true,
    },
});

const data = { value };
const rating = toRef(data, 'value');
const highlightedRating = toRef(data, 'value');

function setRating(ratingValue: number) {
    rating.value = ratingValue;
    highlightedRating.value = ratingValue;

    // emit the rating value
    emits('input', ratingValue);
}

function highlightStars(ratingValue: number) {
    highlightedRating.value = ratingValue;
}

function resetStars() {
    highlightedRating.value = rating.value;
}

function $emit(arg0: string, ratingValue: number) {
    throw new Error('Function not implemented.');
}
</script>

<style scoped>
span {
    display: inline-block;
    cursor: pointer;
    font-size: 20px;
    color: #ccc;
    transition: color 0.3s ease;
}

span.active,
span.active~span,
span.highlighted,
span.highlighted~span {
    color: gold;
}

span:hover~span {
    color: gold;
}
</style>
