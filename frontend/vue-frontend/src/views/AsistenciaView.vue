<script setup>
import { onMounted, ref, watch } from "vue"
import axios from "axios"
import NavBar from '@/components/NavBar.vue';
import Calendario from '@/components/Calendario.vue';
import Buscar from '@/components/Buscar.vue';
import AsistenciaContador from "@/components/AsistenciaContador.vue";

import { useUserStore } from '@/stores/user.js';
const userStore = useUserStore()
const grupo = userStore.grupo
const alumnosInscritos = ref(null)

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
      <p class="text-center my-4 flex-grow-1 fs-2">Asistencia del Día</p>
      <Calendario />
    </div>

    <!-- Aquí va la lista de alumnos -->
    <div class="d-flex gap-3 p-3">
        <AsistenciaContador estado="Presentes" bgcolor="#67BA9F" contador="1"/>
        <AsistenciaContador estado="Ausentes" bgcolor="#F8787D" contador="2"/>
        <AsistenciaContador estado="Retardos" bgcolor="#F8DB7C" contador="3"/>
    </div>
  </div>
</template>