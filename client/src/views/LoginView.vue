<template>
    <Banner pageTitle="Login" />
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="login-container my-5">
                    <h1>Login</h1>
                    <form>
                        <div class="field">
                            <label class="label" for="login">Username</label>
                            <input v-model="loginData.username" @keydown.enter="handleLogin"
                                class="input has-background-dark" type="text" name="username" id="username">
                            <div class="d-flex">
                                <span class="icon px-2"><i></i></span>
                                <p class="help"></p>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label" for="password">Password</label>
                            <input v-model="loginData.password" @keydown.enter="handleLogin"
                                class="input has-background-dark" type="password" name="password" id="password">
                            <div class="d-flex">
                                <span class="icon px-2"><i></i></span>
                                <p class="help"></p>
                            </div>
                        </div>
                        <button @click="handleLogin" class="nav-link btn btn-primary" type="button">Log In</button>
                    </form>
                    <div class="py-3">
                        <p>Heb je nog geen account? <router-link to="/register" class="nav-link"
                                active-class="active">Registreer je hier!</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Banner from './../components/Banner.vue';
import { useAuthenticationStore } from '../stores/authenticationStore';
import Login from './../interfaces/login';
import {
    FieldMessageType,
    setFieldMessage, clearFieldMessages, hasAnyFieldErrors,
} from "./../utils/formUtils.js";

// VARIABLES
const authenticationStore = useAuthenticationStore();
const loginData = ref<Login>({
    username: '',
    password: ''
});

// METHODS
async function handleLogin() {
    // input elements
    const loginEl = document.querySelector("input[name=username]") as HTMLDivElement;
    const passwordEl = document.querySelector("input[name=password]") as HTMLDivElement;

    // ERROR HANDLING
    clearFieldMessages();

    if (!loginData.value.username)
        setFieldMessage(loginEl, FieldMessageType.Error, "Email or username is required.");

    if (!loginData.value.username)
        setFieldMessage(passwordEl, FieldMessageType.Error, "Password is required.");

    if (hasAnyFieldErrors()) return;

    await authenticationStore.login(loginData.value);

}
</script>


<style>
.login-container {
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
