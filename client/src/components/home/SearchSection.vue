<template>
    <div class="d-flex justify-content-center flex-column text-center" id="banner">
        <h1 class="display-6 fw-bold text-white">Kies het perfecte restaurant voor jou</h1>
        <div>
            <input class="w-50" type="text" name="search" id="searchInput" placeholder="Zoek een restaurant of stad">
        </div>
    </div>
</template>

<script setup lang="ts">


</script>

<style scoped>
#searchInput {
    width: 100%;
    height: 50px;
    border: 1px solid #ccc;
    border-radius: 15px;
    padding: 0 10px;
    font-size: 16px;
}

#searchInput:focus {
    outline: none;
}

#banner {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://img.freepik.com/free-vector/pizzeria-cozy-family-cafe-interior-with-oven-pizza-cashier-desk-wooden-tables-chairs-rustic-style_107791-5723.jpg?w=2000');
    height: 50vh !important;
}
</style>