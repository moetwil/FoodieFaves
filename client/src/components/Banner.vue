<template>
    <div>
        <div class="d-flex justify-content-center flex-column text-center" id="banner">
            <h1 class="display-6 fw-bold text-white">
                {{ pageTitle }}
            </h1>
        </div>
    </div>
</template>

<script setup lang="ts">
const { pageTitle } = defineProps({
    pageTitle: {
        type: String,
        required: true
    }
})

</script>
<style scoped>
#banner {
    background: linear-gradient(rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.5)),
        url('https://img.freepik.com/free-vector/pizzeria-cozy-family-cafe-interior-with-oven-pizza-cashier-desk-wooden-tables-chairs-rustic-style_107791-5723.jpg?w=2000');
    height: 35vh !important;
}
</style>
