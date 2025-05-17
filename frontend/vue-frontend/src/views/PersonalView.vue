<script setup>
import NavBar from '@/components/NavBar.vue';
import PersonalCard from '@/components/PersonalCard.vue';
import Buscar from '@/components/Buscar.vue';
import AgregarAlumnoBoton from '@/components/AgregarAlumnoBoton.vue';
import AgregarPersonal from '@/components/AgregarPersonal.vue';
import { onMounted, ref } from "vue"
import axios from "axios"

import { useUserStore } from '@/stores/user.js'
const userStore = useUserStore()
const rolSesion = userStore.rol

const listaDocente = ref([])

onMounted(async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      option: "getPersonal"
    })

    listaDocente.value = response.data.personal
    console.log(listaDocente.value)

    if (Array.isArray(response.data.personal)) {
      listaDocente.value = response.data.personal
    } else {
      listaDocente.value = []
    }

  } catch (error) {
    console.error("Error al obtener lista de alumnos: ", error)
    listaDocente.value = []
  }
})
</script>


<template>
    <div class="container-fluid bg-light min-vh-100 p-0">
        <NavBar />

        <!-- Buscador y botón -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <Buscar />
      <p class="text-center my-4 flex-grow-1 fs-2">Personal</p>
      <AgregarPersonal v-if="rolSesion === 'admin'"/>
    </div>

        

        <div class="container">
            <PersonalCard :docentes="listaDocente"/>
        </div>

    </div>
</template>