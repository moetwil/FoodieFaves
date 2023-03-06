<template>
    <div>
        <Banner :page-title="pageTitle" />
        <div class="container bg-light">
            <div class="row ">
                <div class="col-md-6">
                    <form>
                        <div class=" form-group row d-flex justify-content-start align-items-center">
                            <RatingSelect :value="foodRating" label="Eten:" @input="changeFoodValue" />
                        </div>
                        <div class="form-group row d-flex justify-content-start align-items-center">
                            <RatingSelect :value="serviceRating" label="Eten:" @input="changeServiceValue" />


                        </div>
                        <div class="form-group row d-flex justify-content-start align-items-center">
                            <RatingSelect :value="priceValueRating" label="Eten:" @input="changePriceValueValue" />


                        </div>
                        <div class="form-group">
                            <label for="name">Beschrijf je bezoek</label>
                            <textarea class="form-control" id="description" rows="3"
                                placeholder="Beschrijf je bezoek"></textarea>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Banner from './../components/Banner.vue';
import Review from './../interfaces/Review';
import RatingSelect from './../components/review/RatingSelect.vue';

const foodRating = ref(2);
const serviceRating = ref(4);
const priceValueRating = ref(5);

const pageTitle = 'Schrijf een review';

function changeFoodValue(value: number) {
    console.log(value);
    foodRating.value = value;
}

function changeServiceValue(value: number) {
    console.log(value);
    serviceRating.value = value;
}

function changePriceValueValue(value: number) {
    console.log(value);
    priceValueRating.value = value;
}

</script>

<style scoped></style>