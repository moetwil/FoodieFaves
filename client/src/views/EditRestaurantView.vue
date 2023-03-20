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
                                <input v-model="name" class="input has-background-dark" type="text" name="name" id="name"
                                    tabindex="1">
                                <div class="d-flex">
                                    <span class="icon px-2"><i></i></span>
                                    <p class="help"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="field">
                                <label class="label" for="phone">Telefoon</label>
                                <input v-model="phone" class="input has-background-dark" type="text" name="phone" id="phone"
                                    tabindex="1">
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
                                    <select class="form-select" v-model="category">
                                        <option selected value="1">Kies een categorie</option>
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
                                <ImageUpload @file-selected="handleImageUpload"
                                    :initial-image="imageFile ? imageFile : undefined" />
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
                                    <input v-model="street" class="input has-background-dark" type="text" name="street"
                                        id="street" tabindex="1">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="street">Huisnummer</label>
                                    <input v-model="houseNumber" class="input has-background-dark" type="text"
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
                                    <input v-model="zipCode" class="input has-background-dark" type="text" name="zip-code"
                                        id="zip-code" tabindex="1">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="field">
                                    <label class="label" for="street">Stad</label>
                                    <input v-model="city" class="input has-background-dark" type="text" name="city"
                                        id="city" tabindex="1">
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
                                    <input v-model="country" class="input has-background-dark" type="text" name="country"
                                        id="country" tabindex="1">
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
import Banner from '../components/Banner.vue';
import ImageUpload from '../components/ImageUpload.vue';
import axios from '../utils/axios';
import {
    FieldMessageType,
    setFieldMessage, clearFieldMessages, hasAnyFieldErrors,
} from "../utils/formUtils.js";
import Restaurant from '../interfaces/Restaurant';
const router = useRouter();

// VARIABLES
const id = ref<number | null>(null);
const name = ref('');
const ownerId = ref<number | null>(null);
const phone = ref('');
const street = ref('');
const houseNumber = ref('');
const zipCode = ref('');
const city = ref('');
const country = ref('');
const category = ref(0) as any;
const imageFile = ref('');

onMounted(async () => {
    await fetchRestaurant();
});

async function handleSubmit() {
    // CHECK FOR ERRORS
    if (checkForErrors()) {
        return;
    }

    const updatedRestaurant: Restaurant = {
        id: id.value,
        owner_id: ownerId.value,
        name: name.value,
        phone_number: phone.value,
        street: street.value,
        house_number: houseNumber.value,
        zip_code: zipCode.value,
        city: city.value,
        country: country.value,
        profile_picture: imageFile.value,
        restaurant_type_id: category.value,
    }

    const response = await axios.put(`/restaurants/${id.value}`, updatedRestaurant);
    if (response.status === 200) {
        router.push('/mijn-restaurants');
    }

}

function handleImageUpload(image: string) {
    imageFile.value = image;
}

async function fetchRestaurant() {
    try {
        // get restaurant id from url
        const restaurantId = router.currentRoute.value.params.id;
        const response = await axios.get(`/restaurants/${restaurantId}`);
        if (response.status === 200) {
            id.value = response.data.id;
            name.value = response.data.name;
            ownerId.value = response.data.owner_id;
            phone.value = response.data.phone_number;
            street.value = response.data.street;
            houseNumber.value = response.data.house_number;
            zipCode.value = response.data.zip_code;
            city.value = response.data.city;
            country.value = response.data.country;
            category.value = response.data.restaurant_type_id;
            imageFile.value = response.data.profile_picture;

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

    if (!name.value)
        setFieldMessage(nameEl, FieldMessageType.Error, "Vul alstublieft een naam in.");

    if (!phone.value)
        setFieldMessage(phoneEl, FieldMessageType.Error, "Vul alstublieft een telefoonnummer in.");

    if (!street.value)
        setFieldMessage(streetEl, FieldMessageType.Error, "Vul alstublieft een straat in.");

    if (!houseNumber.value)
        setFieldMessage(houseNumberEl, FieldMessageType.Error, "Vul alstublieft een huisnummer in.");

    if (!zipCode.value)
        setFieldMessage(zipCodeEl, FieldMessageType.Error, "Vul alstublieft een postcode in.");

    if (!city.value)
        setFieldMessage(cityEl, FieldMessageType.Error, "Vul alstublieft een stad in.");

    return hasAnyFieldErrors();
}
</script>


<style>
.create-restaurant-container {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    max-width: 60vw;
    margin: 0 auto;
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
