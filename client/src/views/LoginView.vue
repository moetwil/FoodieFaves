<template>
    <Banner :pageTitle="pageTitle" />
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="login-container my-5">
                    <h1>Login</h1>
                    <form>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input v-model="username" type="text" id="username" name="username"
                                @keydown.enter="handleLogin">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input v-model="password" type="password" id="password" name="password"
                                @keydown.enter="handleLogin">
                        </div>


                        <button @click="handleLogin" class="nav-link btn btn-primary" type="button">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import axios from './../utils/axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Banner from './../components/Banner.vue';
import { useAuthenticationStore } from '../stores/authenticationStore';

const authenticationStore = useAuthenticationStore();
const router = useRouter();

// VARIABLES
const pageTitle = 'Login';
const username = ref('');
const password = ref('');

// METHODS
async function handleLogin() {
    const res = await authenticationStore.login(username.value, password.value);

    if (res) {
        router.push('/');
    }
    else {
        alert("Login failed");
    }

}
</script>


<style>
.login-container {
    background-color: #f2f2f2;
    /* border: 1px solid #ddd; */
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
