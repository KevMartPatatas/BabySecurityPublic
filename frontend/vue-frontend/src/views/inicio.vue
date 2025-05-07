<script setup>
import inicio from '../components/iniciosquare.vue';
</script>

<template>
  <div class="container-fluid bg-light min-vh-100 p-0">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-4">
      <div class="navbar-brand d-flex align-items-center gap-3">
        <span>Gestion</span>
      </div>
      <ul class="navbar-nav flex-row gap-3 ms-5">
        <li class="nav-item"><a class="nav-link active fw-bold" href="#">Inicio</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Gestion de niños</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Asistencia</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Bitacora</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Historial</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Personal</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Reportes</a></li>
      </ul>
      <button class="btn btn-warning ms-auto rounded-circle">
        <i class="bi bi-bell-fill"></i>
      </button>
    </nav>

    <h2 class="text-center my-4">Buenos dias 'user''</h2>

     <!-- Cards -->
     <div class="container">
      <div class="row">
        <div class="col-md-4" v-for="i in 2" :key="i">
          <inicio :bgClass="i % 2 === 0 ? 'bg-info' : 'bg-danger'" />
        </div>
      </div>
    </div>

  </div>
</template>


