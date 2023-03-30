<template>
    <div>
        <Banner page-title="Schrijf een review" />
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6  bg-light p-5 mt-5" id="review-form">
                    <form>
                        <div class="">
                            <div class=" form-group row d-flex justify-content-start align-items-center">
                                <RatingSelect :value="foodRating" id="1" label="het eten"
                                    description="Laat weten wat je van het eten vond. Denk hierbij aan de smaak, de porties."
                                    @input="handleStarsInput" />
                            </div>
                            <div class="form-group row d-flex justify-content-start align-items-center">
                                <RatingSelect :value="serviceRating" id="2" label="de service"
                                    description="Laat weten wat je van de service vond. Denk hierbij aan de bediening, de sfeer en de snelheid."
                                    @input="handleStarsInput" />
                            </div>
                            <div class="form-group row d-flex justify-content-start align-items-center">
                                <RatingSelect :value="priceValueRating" id="3" label="de prijs/kwaliteit"
                                    description="Laat weten wat je van de prijs en kwaliteit vond. Denk hierbij aan de prijs van het eten en de kwaliteit van het eten."
                                    @input="handleStarsInput" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Beschrijf je bezoek</label>
                            <textarea class="form-control" id="description" rows="3"
                                placeholder="Laat weten wat jij goed of juist minder goed vond."
                                v-model="reviewText"></textarea>
                        </div>
                        <ImageUpload class="mt-5" @file-selected="handleImageUpload" />

                    </form>
                    <!-- add a submit button -->
                    <button type="button" class="btn btn-primary mt-3" @click="handleSubmit">Verstuur</button>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Banner from './../components/Banner.vue';
import Review from './../interfaces/Review';
import RatingSelect from './../components/review/RatingSelect.vue';
import ImageUpload from './../components//ImageUpload.vue';
import { useReviewStore } from '../stores/ReviewStore';
import { useAuthenticationStore } from '../stores/AuthenticationStore';

const reviewStore = useReviewStore();
const authenticationStore = useAuthenticationStore();

const router = useRouter();

// get from paremeter url
const restaurantId = +router.currentRoute.value.params.id;

// ratings
const foodRating = ref(0);
const serviceRating = ref(0);
const priceValueRating = ref(0);
const reviewText = ref('');
const imageFile = ref<string | null>(null);

function handleStarsInput(value: number, id: string) {
    switch (id) {
        case '1':
            foodRating.value = value;
            break;
        case '2':
            serviceRating.value = value;
            break;
        case '3':
            priceValueRating.value = value;
            break;
    }

    console.log(id);
}

// function handleImageUpload(file: File) {

//     console.log(file);

//     // imageFile.value = file;
// }


function handleImageUpload(image: string) {
    console.log(image);
    imageFile.value = image;
}

function handleSubmit() {

    const userId = authenticationStore.getUser?.id;
    if (!userId) {
        router.push('/login');
        return;
    }

    const review: Review = {
        restaurant_id: restaurantId,
        food_rating: foodRating.value,
        service_rating: serviceRating.value,
        price_value_rating: priceValueRating.value,
        review_text: reviewText.value,
        id: null,
        user_id: userId,
        flagged: false,
        approved: false,
        date: null,
        // image: imageFile.value ? imageFile.value.name : null
        image: imageFile.value
    };

    console.log(review);

    reviewStore.setReview(review);
    console.log(reviewStore.getReview);
    reviewStore.createReview();

    router.push(`/restaurant/${restaurantId}`);
}



</script>

<style scoped>
label {
    font-size: 22px;
    font-weight: 600;
    color: #000;
}

#review-form {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
}
</style>