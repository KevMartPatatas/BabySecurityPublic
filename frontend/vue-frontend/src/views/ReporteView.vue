<script setup>
import { ref, computed, onMounted } from 'vue'

const busqueda = ref('')
const fecha = ref('2025-04-01')
const personaSeleccionada = ref({})
import NavBar from '@/components/NavBar.vue'
import Buscar from '@/components/Buscar.vue'
import GenerarReporte from '@/components/GenerarReporte.vue'
import axios from "axios"
import CrearReporte from '@/components/CrearReporte.vue'
import LeerEditarReporte from '@/components/LeerEditarReporte.vue'


const listaDocente = ref([])

onMounted(async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      option: "getPersonal"
    })

    listaDocente.value = response.data
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
    <!-- Navbar -->
    <NavBar />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <Buscar />
      <p class="text-center my-4 flex-grow-1 fs-2">Reportes</p>
    </div>

    <!-- Contenido principal -->
    <div class="container-fluid bg-light min-vh-100 py-4 px-5">
      <div class="row g-4">
        <!-- Tarjeta: Crear Reporte -->
        <div class="col-md-4">
          <CrearReporte :docentes="listaDocente" />
        </div>

        <!-- Tarjeta: Leer y Editar Reportes -->
        <div class="col-md-4">
          <LeerEditarReporte />
        </div>
      </div>
    </div>
  </div>

</template>