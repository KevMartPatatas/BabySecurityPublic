<script setup>
import { onMounted, ref, watch } from "vue"
import axios from "axios"
import AlumnosInscritosCard from "@/components/AlumnosInscritosCard.vue";
import NavBar from '@/components/NavBar.vue';
import Buscar from '@/components/Buscar.vue';
import AgregarAlumnoBoton from '@/components/AgregarAlumnoBoton.vue';

import { useUserStore } from '@/stores/user.js';
const userStore = useUserStore()
const grupo = userStore.grupo
const alumnosInscritos = ref([])


onMounted(async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      grupo: grupo,
      option: "getAlumnos"
    })
    alumnosInscritos.value = response.data.alumnos

    console.log("Alumnos: ", alumnosInscritos.value)
  } catch (error) {
      console.error("Error al obtener lista de alumnos: ", error)
    }

})
</script>

<template>
  <div class="container-fluid bg-light min-vh-100 p-0">
    <!-- Navbar -->
    <NavBar />

    <!-- Buscador y botón -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <Buscar />
      <p class="text-center my-4 flex-grow-1 fs-2">Alumnos inscritos</p>
      <AgregarAlumnoBoton />
    </div>

    <!-- Aquí va la lista de alumnos -->
    <div class="container">
      <AlumnosInscritosCard :alumnos="alumnosInscritos" />
    </div>
  </div>
</template>


