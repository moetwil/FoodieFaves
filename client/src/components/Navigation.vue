<template>
  <nav class="navbar navbar-expand-lg sticky bg-white navbar-light">
    <div class="container">
      <router-link to="/" class="nav-link" active-class="active navbar-brand">FoodieFaves</router-link>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
          </li>
          <li class="nav-item">
            <router-link to="/userreview" class="nav-link" active-class="active">
              <font-awesome-icon icon="fa-solid fa-pencil" />
              Beoordeling</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/login" class="nav-link btn btn-primary" active-class="active">
              Inloggen
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<!-- Navbar --></template>

<script setup lang="ts">

</script>

<style>
.nav-link {
  font-size: 17px;
  font-weight: 600;
  color: #000 !important;
  padding-left: 20px !important;
  padding-right: 20px !important;
}

.btn-primary {
  background-color: #000;
  border: none;
  color: #fff !important;
  border-radius: 100px;
  border: 1px solid #000 !important;
}

.btn-primary:hover {
  color: #000 !important;
  background-color: #fff !important;

}

.navbar-brand {
  font-size: 25px !important;
  padding-left: 0px !important;
}
</style>