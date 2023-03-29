<template>
    <div class="form-group d-flex justify-content-between flex-row">
        <div class="col-md-8">
            <label>Beoordeel <span class="type-label">{{ label }} </span></label>
            <p class="description">{{ description }}</p>
        </div>

        <div>
            <span v-for="(star, index) in stars" :key="index" @click="setRating(index + 1)"
                :class="{ 'highlighted': star.highlighted }">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, ref, watch } from 'vue';

const emits = defineEmits(['input']);

const { id, label, value, description } = defineProps({

    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    }
    ,
    value: {
        type: Number,
        required: true,
    },
});

// make a ref to the value prop
const rating = ref(value)

// watch for changes in the value prop
watch(rating, (newValue) => {
    emits('input', newValue, id);
});

// create an array of stars
const stars = computed(() => {
    const highlightedCount = Math.floor(rating.value);
    const stars = Array.from({ length: 5 }).map((_, index) => ({
        highlighted: index < highlightedCount,
    }));
    const decimal = rating.value - highlightedCount;
    if (decimal > 0) {
        stars[highlightedCount].highlighted = true;
    }
    return stars;
});

// set the rating on click
function setRating(ratingValue: number) {
    rating.value = ratingValue;
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

span:hover,
span.highlighted {
    color: gold;
}

i.highlighted {
    color: gold;
}

.description {
    font-size: 14px;
    color: #5c5c5c;
}

label {
    font-size: 22px;
    font-weight: 600;
    color: #000;
}

.type-label {
    font-size: 22px;
    font-weight: 700;
    color: #cc9123;
}
</style>
