<script setup>
import { onMounted, ref, watch } from "vue"
import axios from "axios"
import AlumnosInscritosCard from "@/components/AlumnosInscritosCard.vue";
import NavBar from '@/components/NavBar.vue';
import Buscar from '@/components/Buscar.vue';
import AgregarAlumnoBoton from '@/components/AgregarAlumnoBoton.vue';
import { useUserStore } from "@/stores/user.js";

const userStore = useUserStore()
const matricula = userStore.matricula
const alumnosInscritos = ref([])
const rolSesion = userStore.rol


onMounted(async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      matricula: matricula,
      option: "getAlumnos"
    })

    // Verificamos que exista y sea array
    if (Array.isArray(response.data.alumnos)) {
      alumnosInscritos.value = response.data.alumnos
    } else {
      alumnosInscritos.value = []
    }

    console.log("Alumnos: ", alumnosInscritos.value)
  } catch (error) {
    console.error("Error al obtener lista de alumnos: ", error)
    alumnosInscritos.value = []
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
      <AgregarAlumnoBoton v-if="rolSesion === 'admin'"/>
    </div>

    <!-- Aquí va la lista de alumnos -->
    <div class="container">
      <AlumnosInscritosCard :alumnos="alumnosInscritos" />
    </div>
  </div>
</template>
