<template>
    <Banner pageTitle="Mijn account" />
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="update-account-container my-5">
                    <h1>Gegevens</h1>
                    <form>
                        <div class="row">
                            <div class="col">
                                <div class="field">
                                    <label class="label" for="firstname">Voornaam</label>
                                    <input v-model="firstname" @keydown.enter="handleUserUpdate"
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
                                    <input v-model="lastname" @keydown.enter="handleUserUpdate"
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
                                    <input v-model="username" @keydown.enter="handleUserUpdate"
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
                                    <input v-model="email" @keydown.enter="handleUserUpdate"
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
                                    <label class="label" for="password">Password</label>
                                    <input v-model="password" @keydown.enter="handleUserUpdate"
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
                                    <label class="label" for="passwordConfirm">Password herhalen</label>
                                    <input v-model="passwordConfirm" @keydown.enter="handleUserUpdate"
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
                                <ImageUpload @file-selected="handleImageUpload"
                                    :initial-image="imageFile ? imageFile : undefined" />
                            </div>
                        </div>
                        <button @click="handleUserUpdate" class="nav-link btn btn-primary" type="button">Update
                            account</button>
                        <div class="mt-4">
                            <p id="success-message">{{ successMessage }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Banner from '../components/Banner.vue';
import { useAuthenticationStore } from '../stores/authenticationStore';
import ImageUpload from '../components/ImageUpload.vue';
import {
    FieldMessageType,
    setFieldMessage, clearFieldMessages, hasAnyFieldErrors,
} from "../utils/formUtils.js";
import User from '../interfaces/User';

const authenticationStore = useAuthenticationStore();
const router = useRouter();

// VARIABLES
const id = ref();
const firstname = ref('');
const lastname = ref('');
const username = ref('');
const email = ref('');
const password = ref('');
const passwordConfirm = ref('');
const imageFile = ref<string | null>(null);
const successMessage = ref('');

// METHODS
onMounted(() => {

    // if the authentication store has no user object, redirect to login page
    if (!authenticationStore.user) {
        router.push('/login');
    }

    // get userdata from store
    const user = authenticationStore.user;
    if (user) {
        id.value = user.id;
        firstname.value = user.first_name;
        lastname.value = user.last_name;
        username.value = user.username;
        email.value = user.email;
        imageFile.value = user.profile_picture;
    }
});

async function handleUserUpdate() {
    // check if all fields are filled in
    if (checkForErrors()) {
        return;
    }

    // create user object
    const updatedUser: User = {
        id: id.value,
        first_name: firstname.value,
        last_name: lastname.value,
        username: username.value,
        email: email.value,
        password: password.value,
        profile_picture: imageFile.value,
        is_admin: 0,
        user_type: 0
    }
    successMessage.value = "Je profiel is succesvol aangepast!";

    const res = await authenticationStore.updateUser(updatedUser);

    if (await res === true) {
        // set success message
        successMessage.value = "Je profiel is succesvol aangepast!";
    }
    else {
        alert("Er is iets fout gegaan. Probeer het later opnieuw.")
    }

}

function handleImageUpload(image: string) {
    console.log(image);
    imageFile.value = image;
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

    if (!firstname.value)
        setFieldMessage(firstnameEl, FieldMessageType.Error, "Vul alstublieft een voornaam in.");

    if (!lastname.value)
        setFieldMessage(lastnameEl, FieldMessageType.Error, "Vul alstublieft een achternaam in.");

    if (!username.value)
        setFieldMessage(usernameEl, FieldMessageType.Error, "Vul alstublieft een username in.");

    if (!email.value)
        setFieldMessage(emailEl, FieldMessageType.Error, "Vul alstublieft een email in.");

    // check if passwords match
    if (password.value !== passwordConfirm.value)
        setFieldMessage(passwordConfirmEl, FieldMessageType.Error, "Wachtwoorden komen niet overeen.");

    return hasAnyFieldErrors();
}
</script>


<style>
.update-account-container {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    max-width: 30vw;
    margin: 0 auto;
}

h1 {
    text-align: center;
    font-size: 32px;
    margin-bottom: 20px;
}

#success-message {
    color: green;
    font-size: 16px;
    text-align: center;
}
</style>
