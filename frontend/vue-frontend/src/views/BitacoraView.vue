<script setup>
import NavBar from '@/components/NavBar.vue';
import Calendario from '@/components/Calendario.vue';
import Buscar from '@/components/Buscar.vue';
import { onMounted, ref, watch } from "vue"
import axios from "axios"
import BitacoraAlumnos from "@/components/BitacoraAlumnos.vue";
import { useUserStore } from '@/stores/user.js'
const userStore = useUserStore()
const grupo = userStore.clave_grupo
const actividad = userStore.clave_actividad
const alumnosBitacora = ref([])
const seleccionActividad = ref([])

onMounted(async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      clave_grupo: grupo,
      option: "getBitacora"
    })

    if (Array.isArray(response.data.alumnos)) {
      alumnosBitacora.value = response.data.alumnos
    } else {
      alumnosBitacora.value = []
    }
    console.log("Alumnos: ", response)
  } catch (error) {
    console.error("Error al obtener lista de alumnos: ", error)
  }

  try {
    const response2 = await axios.post("http://localhost:80/api/Index.php", {
      option: "SelectActBitacora"
    })

    if (Array.isArray(response2.data.Actividad)) {
      seleccionActividad.value = response2.data.Actividad
    } else {
      seleccionActividad.value = []
    }
    console.log("Actividad: ", response2)
  } catch (error) {
    console.error("Error al obtener lista de actividades: ", error)
  }

})


</script>


<template>
  <div class="container-fluid bg-light min-vh-100 p-0">
    <!--navbar-->
    <NavBar />

    <!-- Buscador y botón -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <Buscar />
      <p class="text-center my-4 flex-grow-1 fs-2">Bitacora de Actividades</p>
      <Calendario />
    </div>

    <!-- Aquí va la lista de alumnos -->
    <div class="container">
      <BitacoraAlumnos :Actividad="seleccionActividad" :alumnos="alumnosBitacora" />

    </div>


  </div>

</template>