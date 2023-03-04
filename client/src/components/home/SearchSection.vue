<template>
    <div>
        <div class="d-flex justify-content-center flex-column text-center" id="banner">
            <h1 class="display-6 fw-bold text-white">
                Kies het perfecte restaurant voor jou
            </h1>
            <div>
                <input class="w-50" type="text" name="search" id="searchInput" placeholder="Zoek een restaurant of stad"
                    v-model="searchQuery" />
                <div class="search-results">
                    <div v-for="(result, index) in paginatedResults" :key="result.id" class="search-result">
                        <div class="result-name">{{ result.name }}</div>
                        <div class="result-location">{{ result.city }}</div>
                    </div>
                    <div v-if="showNoResults" class="search-result">
                        <div class="result-name">Niets gevonden</div>
                        <div class="result-location">Probeer een andere zoekopdracht.</div>
                    </div>
                    <div v-if="showPagination" class="pagination">
                        <button v-if="currentPage > 1" @click="currentPage--" class="page-link">
                            Vorige
                        </button>
                        <button v-for="page in pages" :key="page" @click="currentPage = page" class="page-link"
                            :class="{ active: page === currentPage }">
                            {{ page }}
                        </button>
                        <button v-if="currentPage < totalPages" @click="currentPage++" class="page-link">
                            Volgende
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import Restaurant from "./../../interfaces/Restaurant";

const searchQuery = ref('');
const searchResults = ref<Restaurant[]>([]);
const noResultsMessage = "Niets gevonden";
const noResults = { id: -1, name: noResultsMessage, city: '' };
const perPage = 3;
let currentPage = ref(1);

watch(searchQuery, async (newQuery: string) => {
    const response = await fetch(`http://localhost/api/restaurants/search/${newQuery}`);
    const results = await response.json();
    searchResults.value = results.length ? results : [];
});

const totalPages = computed(() => Math.ceil(searchResults.value.length / perPage));
const pages = computed(() => {
    const pagesArray = [];
    for (let i = 1; i <= totalPages.value; i++) {
        pagesArray.push(i);
    }
    return pagesArray;
});

const paginatedResults = computed(() => {
    const startIndex = (currentPage.value - 1) * perPage;
    const endIndex = startIndex + perPage;
    return searchResults.value.slice(startIndex, endIndex);
});

const showNoResults = computed(() => {
    return searchResults.value.length === 0 && searchQuery.value !== '';
});

const showPagination = computed(() => {
    return searchResults.value.length > perPage;
});
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
    background: linear-gradient(rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.5)),
        url('https://img.freepik.com/free-vector/pizzeria-cozy-family-cafe-interior-with-oven-pizza-cashier-desk-wooden-tables-chairs-rustic-style_107791-5723.jpg?w=2000');
    height: 50vh !important;
}

/* Search results */
.search-results {
    width: 48%;
    margin: auto;
    border-radius: 5px;
    background-color: #f8f8f8;
    border: none;
}

.search-result {
    display: flex;
    justify-content: space-between;
    padding: 10px;
}

.search-result:hover {
    background-color: #f1f1f1;
}

.result-name {
    font-weight: bold;
    font-size: 16px;
}

.result-location {
    color: #666;
    font-size: 14px;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
}

.page-link {
    border: none;
    background-color: transparent;
    color: #333;
    cursor: pointer;
}

.page-link:hover {
    background-color: #f1f1f1;
    border-radius: 5px;
}
</style>
