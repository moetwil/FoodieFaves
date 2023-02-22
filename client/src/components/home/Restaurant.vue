<template>
    <div class="col-md-4">
        <div class="card p-3 mb-2">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <div class="icon">
                        <img src="https://img.icons8.com/ios/50/000000/restaurant.png" />
                    </div>
                </div>
                <div class="badge"> <span>4/5 ⭐</span> </div>
            </div>
            <div class="mt-5">
                <h3 class="heading">La Picoletta</h3>
                <div class="adres">
                    <p class="text1">Zijlweg 1</p>
                    <p class="text1">1111AA Haarlem</p>
                </div>

                <div class="mt-5">
                    <div class="mt-3">
                        <p class="text1">32 Reviews
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

</script>

<style scoped>
.card {
    background-color: #f9f9f988;
}

.card {
    border: none;
    border-radius: 10px;
    /* border-color: #efefef; */
}

.c-details span {
    font-weight: 300;
    font-size: 13px
}

.icon {
    width: 75px;
    height: 75px;
    background-color: #eee;
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 39px
}

.badge span {
    background-color: #fffbec;
    width: 60px;
    height: 25px;
    padding-bottom: 3px;
    border-radius: 5px;
    display: flex;
    color: #5b5b5b;
    justify-content: center;
    align-items: center;
    font-size: 15px;
}

.text1 {
    font-size: 14px;
    font-weight: 600
}
</style>