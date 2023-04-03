<template>
    <Banner pageTitle="Registeren" />
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="form-container my-5">
                    <h1>Maak een account aan</h1>
                    <form>

                        <div class="row">
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="firstname">Voornaam</label>
                                    <input v-model="user.first_name" @keydown.enter="handleRegister"
                                        class="input has-background-dark" type="text" name="firstname" id="firstname"
                                        tabindex="1">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="lastname">Achternaam</label>
                                    <input v-model="user.last_name" @keydown.enter="handleRegister"
                                        class="input has-background-dark" type="text" name="lastname" id="lastname"
                                        tabindex="2">
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
                                    <label class="label" for="username">Username</label>
                                    <input v-model="user.username" @keydown.enter="handleRegister"
                                        class="input has-background-dark" type="text" name="username" id="username"
                                        tabindex="3">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>

                            </div>
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="email">Email</label>
                                    <input v-model="user.email" @keydown.enter="handleRegister"
                                        class="input has-background-dark" type="text" name="email" id="email" tabindex="4">
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
                                    <label class="label" for="password">Wachtwoord</label>
                                    <input v-model="user.password" @keydown.enter="handleRegister"
                                        class="input has-background-dark" type="password" name="password" id="password"
                                        tabindex="5">
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="passwordConfirm">Wachtwoord herhalen</label>
                                    <input v-model="passwordConfirm" @keydown.enter="handleRegister"
                                        class="input has-background-dark" type="password" name="passwordConfirm"
                                        id="passwordConfirm" tabindex="6">
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
                        <div class="row pt-1">
                            <div class="col">
                                <div class="field">
                                    <div class="row">
                                        <div class="col">
                                            <input type="checkbox" name="restaurant-owner" id="restaurant-owner"
                                                v-model="user.user_type">
                                            <label class="px-2" for="restaurant-owner">Ik ben een restaurant
                                                eigenaar</label>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <span class="icon px-2"><i></i></span>
                                        <p class="help"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button @click="handleRegister" class="nav-link btn btn-primary" type="button">Registreer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Banner from '../components/Banner.vue';
import { useAuthenticationStore } from '../stores/AuthenticationStore';
import ImageUpload from '../components/ImageUpload.vue';
import User from '../interfaces/User';
import {
    FieldMessageType,
    setFieldMessage, clearFieldMessages, hasAnyFieldErrors,
} from "../utils/formUtils.js";

const authenticationStore = useAuthenticationStore();

// VARIABLES
const user = ref<User>({
    id: undefined,
    first_name: '',
    last_name: '',
    username: '',
    email: '',
    password: '',
    profile_picture: '',
    is_admin: 0,
    user_type: 0,
});
const passwordConfirm = ref('');


// METHODS
async function handleRegister() {
    if (checkForErrors()) {
        return;
    }

    // set user_type to 1 if checked
    user.value.user_type = user.value.user_type ? 1 : 0;

    // register user
    await authenticationStore.register(user.value);
}

function handleImageUpload(image: string) {
    user.value.profile_picture = image;
}

function checkForErrors() {
    // input elements
    const firstnameEl = document.querySelector("input[name=firstname]") as HTMLDivElement;
    const lastnameEl = document.querySelector("input[name=lastname]") as HTMLDivElement;
    const usernameEl = document.querySelector("input[name=username]") as HTMLDivElement;
    const emailEl = document.querySelector("input[name=email]") as HTMLDivElement;
    const passwordEl = document.querySelector("input[name=password]") as HTMLDivElement;
    const passwordConfirmEl = document.querySelector("input[name=passwordConfirm]") as HTMLDivElement;

    // ERROR HANDLING
    clearFieldMessages();

    if (!user.value?.first_name)
        setFieldMessage(firstnameEl, FieldMessageType.Error, "Vul alstublieft een voornaam in.");

    if (!user.value?.last_name)
        setFieldMessage(lastnameEl, FieldMessageType.Error, "Vul alstublieft een achternaam in.");

    if (!user.value?.username)
        setFieldMessage(usernameEl, FieldMessageType.Error, "Vul alstublieft een username in.");

    if (!user.value?.email)
        setFieldMessage(emailEl, FieldMessageType.Error, "Vul alstublieft een email in.");

    if (user.value?.email && !user.value?.email.includes("@"))
        setFieldMessage(emailEl, FieldMessageType.Error, "Vul alstublieft een geldig email in.");

    if (!user.value?.password)
        setFieldMessage(passwordEl, FieldMessageType.Error, "Vul alstublieft een wachtwoord in.");

    if (!passwordConfirm.value)
        setFieldMessage(passwordConfirmEl, FieldMessageType.Error, "Herhaal uw wachtwoord");

    if (user.value?.password && passwordConfirm.value && user.value?.password !== passwordConfirm.value)
        setFieldMessage(passwordConfirmEl, FieldMessageType.Error, "Wachtwoorden komen niet overeen.");

    return hasAnyFieldErrors();
}
</script>


<style>
/* make container on pc efefef background */
.form-container {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
}

/* on pc make form-container 30vw */
@media (min-width: 768px) {
    .form-container {
        width: 30vw;
        margin: 0 auto;
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
