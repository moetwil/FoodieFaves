<template>
    <div>
        <Banner page-title="Schrijf een review" />
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6  bg-light p-5 mt-5" id="review-form">
                    <form>
                        <div class="">
                            <div class=" form-group row d-flex justify-content-start align-items-center">
                                <RatingSelect :value="review.food_rating" id="1" label="het eten"
                                    description="Laat weten wat je van het eten vond. Denk hierbij aan de smaak, de porties."
                                    @input="handleStarsInput" />
                            </div>
                            <div class="form-group row d-flex justify-content-start align-items-center">
                                <RatingSelect :value="review.service_rating" id="2" label="de service"
                                    description="Laat weten wat je van de service vond. Denk hierbij aan de bediening, de sfeer en de snelheid."
                                    @input="handleStarsInput" />
                            </div>
                            <div class="form-group row d-flex justify-content-start align-items-center">
                                <RatingSelect :value="review.price_value_rating" id="3" label="de prijs/kwaliteit"
                                    description="Laat weten wat je van de prijs en kwaliteit vond. Denk hierbij aan de prijs van het eten en de kwaliteit van het eten."
                                    @input="handleStarsInput" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Beschrijf je bezoek</label>
                            <textarea class="form-control" id="description" maxlength="200" rows="3"
                                placeholder="Laat weten wat jij goed of juist minder goed vond."
                                v-model="review.review_text"></textarea>
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

// VARIABLES
const restaurantId = +router.currentRoute.value.params.id;
const review = ref<Review>({
    id: undefined,
    restaurant_id: restaurantId,
    user_id: undefined,
    food_rating: 0,
    service_rating: 0,
    price_value_rating: 0,
    review_text: '',
    flagged: false,
    approved: false,
    date: undefined,
    image: undefined
});

function handleStarsInput(value: number, id: string) {
    switch (id) {
        case '1':
            review.value.food_rating = value;
            break;
        case '2':
            review.value.service_rating = value;
            break;
        case '3':
            review.value.price_value_rating = value;
            break;
    }
}


function handleImageUpload(image: string) {
    console.log(image);
    // imageFile.value = image;
    review.value.image = image;
}

function handleSubmit() {

    // check if user is logged in
    const userId = authenticationStore.getUser?.id;
    if (!userId) {
        router.push('/login');
        return;
    }

    // set user id
    review.value.user_id = userId;

    // set date
    reviewStore.setReview(review.value);
    reviewStore.createReview();

    // redirect to restaurant page
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