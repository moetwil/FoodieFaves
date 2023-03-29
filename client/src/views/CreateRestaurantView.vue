<template>
    <Banner pageTitle="Maak een nieuw restaurant" />
    <div class="container">
        <div class="create-restaurant-container my-5">
            <form @keydown.enter="handleSubmit">
                <div class="row">
                    <!-- linker column -->
                    <div class="col">
                        <h2>Restaurant gegevens</h2>
                        <div class="row">
                            <div class="field">
                                <label class="label" for="name">Naam</label>
                                <input v-model="restaurant.name" class="input has-background-dark" type="text" name="name"
                                    id="name" tabindex="1">
                                <div class="d-flex">
                                    <span class="icon px-2"><i></i></span>
                                    <p class="help"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="field">
                                <label class="label" for="phone">Telefoon</label>
                                <input v-model="restaurant.phone_number" class="input has-background-dark" type="text"
                                    name="phone" id="phone" tabindex="1">
                                <div class="d-flex">
                                    <span class="icon px-2"><i></i></span>
                                    <p class="help"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="category">Categorie</label>
                                    <select class="form-select" v-model="restaurant.restaurant_type_id">
                                        <option selected value="0">Kies een restaurant type</option>
                                        <option v-for="restaurantType in restaurantTypes" :key="restaurantType.id"
                                            :value="restaurantType.id">{{ restaurantType.name }}
                                        </option>
                                    </select>
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <ImageUpload @file-selected="handleImageUpload" />
                            </div>
                        </div>
                    </div>
                    <!-- rechter column -->
                    <div class="col">
                        <h2>Adres</h2>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="field">
                                    <label class="label" for="street">Straat</label>
                                    <input v-model="restaurant.street" class="input has-background-dark" type="text"
                                        name="street" id="street" tabindex="1">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="street">Huisnummer</label>
                                    <input v-model="restaurant.house_number" class="input has-background-dark" type="text"
                                        name="house-number" id="house-number" tabindex="1">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="street">Postcode</label>
                                    <input v-model="restaurant.zip_code" class="input has-background-dark" type="text"
                                        name="zip-code" id="zip-code" tabindex="1">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="field">
                                    <label class="label" for="street">Stad</label>
                                    <input v-model="restaurant.city" class="input has-background-dark" type="text"
                                        name="city" id="city" tabindex="1">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="street">Land</label>
                                    <input v-model="restaurant.country" class="input has-background-dark" type="text"
                                        name="country" id="country" tabindex="1">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <button @click="handleSubmit" class="nav-link btn btn-primary" type="button">Maak restaurant</button>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthenticationStore } from '../stores/authenticationStore';
import {
    FieldMessageType,
    setFieldMessage, clearFieldMessages, hasAnyFieldErrors,
} from "../utils/formUtils.js";
import Restaurant from '../interfaces/Restaurant';
import RestaurantType from '../interfaces/RestaurantType';
import Banner from '../components/Banner.vue';
import ImageUpload from '../components/ImageUpload.vue';
import axios from './../utils/axios';
const router = useRouter();

// VARIABLES
const restaurantTypes = ref<RestaurantType[]>([]);
const restaurant = ref<Restaurant>({
    name: '',
    phone_number: '',
    street: '',
    house_number: '',
    zip_code: '',
    city: '',
    country: '',
    restaurant_type_id: 0,
    profile_picture: '',
});

onMounted(async () => {
    await fetchRestaurantTypes();
});

async function handleSubmit() {
    // CHECK FOR ERRORS
    if (checkForErrors()) {
        return;
    }

    // post restaurant
    const response = await axios.post('/restaurants', restaurant.value);
    router.push('/mijn-restaurants');

}

function handleImageUpload(image: string) {
    restaurant.value!.profile_picture = image;
}

async function fetchRestaurantTypes() {
    try {
        const response = await axios.get('/restaurant-types');
        if (response.status === 200) {
            restaurantTypes.value = response.data;
        }
    } catch (error) {
        console.log(error);
    }

}

function checkForErrors() {
    // input elements
    const nameEl = document.querySelector("input[name=name]") as HTMLDivElement;
    const phoneEl = document.querySelector("input[name=phone]") as HTMLDivElement;
    const streetEl = document.querySelector("input[name=street]") as HTMLDivElement;
    const houseNumberEl = document.querySelector("input[name=house-number]") as HTMLDivElement;
    const zipCodeEl = document.querySelector("input[name=zip-code]") as HTMLDivElement;
    const cityEl = document.querySelector("input[name=city]") as HTMLDivElement;

    // ERROR HANDLING
    clearFieldMessages();

    if (!restaurant.value?.name)
        setFieldMessage(nameEl, FieldMessageType.Error, "Vul alstublieft een naam in.");

    if (!restaurant.value?.phone_number)
        setFieldMessage(phoneEl, FieldMessageType.Error, "Vul alstublieft een telefoonnummer in.");

    if (!restaurant.value?.street)
        setFieldMessage(streetEl, FieldMessageType.Error, "Vul alstublieft een straat in.");

    if (!restaurant.value?.house_number)
        setFieldMessage(houseNumberEl, FieldMessageType.Error, "Vul alstublieft een huisnummer in.");

    if (!restaurant.value?.zip_code)
        setFieldMessage(zipCodeEl, FieldMessageType.Error, "Vul alstublieft een postcode in.");

    if (!restaurant.value?.city)
        setFieldMessage(cityEl, FieldMessageType.Error, "Vul alstublieft een stad in.");

    return hasAnyFieldErrors();
}
</script>


<style>
.create-restaurant-container {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    /* max-width: 60vw; */
    margin: 0 auto;
}

/* on mobile create-restaurant-container 80% */
@media only screen and (max-width: 600px) {
    .create-restaurant-container {
        max-width: 80%;
    }
}

h1 {
    text-align: center;
    font-size: 32px;
    margin-bottom: 20px;
}


label {
    font-size: 17px;
    margin-bottom: 10px;
}

input[type="text"],
input[type="password"] {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    font-size: 16px;
    margin-bottom: 20px;
    width: 100%;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

button[type="submit"]:hover {
    background-color: #3e8e41;
}
</style>
