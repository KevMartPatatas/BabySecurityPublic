<script setup>
import NavBar from '@/components/NavBar.vue';
import InicioActividades from '@/components/InicioActividades.vue';
import documentoImg from '@/assets/documento.png'
import notificacionesImg from '@/assets/notificaciones.png'

  import { useUserStore } from '@/stores/user.js';

  const userStore = useUserStore()
  const nombre = userStore.nombre

  console.log(nombre)
</script>

<template>
  <div class="container-fluid bg-light min-vh-100 p-0">
    <!-- Navbar -->
    <NavBar />

    <p class="justify-left my-4 ms-5 fs-2">Buenos dias {{ nombre }} ☀️</p>

     <!-- Cards -->
    <div class="ms-5 d-flex justify-content-start gap-3 flex-wrap">
      <RouterLink to="/resumen">
        <InicioActividades titulo="Itinerario" :img="documentoImg" bgcolor="#80CEE1" textcolor="#1E3A5F"/>
      </RouterLink>
      <RouterLink to="/notificaciones">
        <InicioActividades titulo="Notificaciones" :img="notificacionesImg" bgcolor="#FFE599" textcolor="#6B4226"/>
      </RouterLink>
    </div>

  </div>
</template>


