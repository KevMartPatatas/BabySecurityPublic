<script setup>
import LoginForm from '../components/LoginForm.vue'
</script>

<template>
    <div class="d-flex justify-content-center align-items-center vh-100 position-relative">
    <!-- Imagen de fondo centrada -->
    <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="opacity: 50%;" alt="Vue logo" src="@/assets/fondo_login.png" width="1250" height="1250" />
    <LoginForm />
  </div>
</template>