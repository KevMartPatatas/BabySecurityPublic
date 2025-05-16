<script setup>
import { onMounted, ref } from "vue"
import axios from "axios"

import NavBar from '@/components/NavBar.vue'
import Calendario from '@/components/Calendario.vue'
import Buscar from '@/components/Buscar.vue'
import AsistenciaContador from "@/components/AsistenciaContador.vue"
import AsistenciaAlumnos   from "@/components/AsistenciaAlumnos.vue"

import { useUserStore } from '@/stores/user.js'
const userStore = useUserStore()
const matricula = userStore.matricula
const clave_grupo = userStore.clave_grupo

const alumnosInscritos = ref([])
const presentes  = ref(0)
const ausentes   = ref(0)
const retardos   = ref(0)

const asistenciaComponent = ref(null)

const registros = ref([])
const listaAsistencia = ref(null)
const nocontrol = ref([])
const nombre = ref([])


onMounted(async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      clave_grupo: clave_grupo,
      option: "getAsistencias"
    })

    nocontrol.value = response.data.listaAsistencia

    // Verificamos que exista y sea array
    if (Array.isArray(response.data.listaAsistencia)) {
      listaAsistencia.value = response.data.listaAsistencia
    } else {
      listaAsistencia.value = [] // Valor por defecto
    }

    console.log("Lista de : ", listaAsistencia.value)
  } catch (error) {
    console.error("Error al obtener lista de alumnos: ", error)
    listaAsistencia.value = [] // fallback en caso de error
  }
})

async function enviarFormularioAsistencia() {
  asistenciaComponent.value?.emitirAsistencias()
  console.log('Datos a enviar:', registros.value)

  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      asistencias: registros.value,
      option: "guardarAsistencia"
    })

    console.log("Respuesta del servidor: ", response.data)
  }
  catch (error) {
    console.error("Error al guardar el registro de asistencias")
  }
}

function recibirAsistencias(datos) {
  registros.value = datos // Guardamos los datos que vienen del componente hijo
  console.log('Datos recibidos del hijo:', datos)
}

onMounted(async () => {
  try {
    const { data } = await axios.post("http://localhost:80/api/Index.php", {
      matricula, option: "getAlumnos"
    })
    alumnosInscritos.value = Array.isArray(data.alumnos) ? data.alumnos : []
  } catch {
    alumnosInscritos.value = []
  }
})

// Manejador del evento que viene del hijo
function handleUpdateCounts({ presentes: p, ausentes: a, retardos: r }) {
  presentes.value = p
  ausentes.value  = a
  retardos.value  = r
}
</script>

<template>
  <form @submit.prevent="enviarFormularioAsistencia">
    <div class="container-fluid bg-light min-vh-100 p-0">
    <NavBar />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <Buscar />
      <p class="text-center my-4 flex-grow-1 fs-2">Asistencia del Día</p>
      <Calendario />
    </div>

    <!-- Contadores y botón alineado a la derecha -->
<div class="d-flex align-items-center gap-3 p-3">
  <AsistenciaContador estado="Presentes" bgcolor="#67BA9F" :contador="presentes"/>
  <AsistenciaContador estado="Ausentes"  bgcolor="#F8787D" :contador="ausentes"/>
  <AsistenciaContador estado="Retardos"  bgcolor="#F8DB7C" :contador="retardos"/>

  <!-- El botón se va a la derecha gracias a ms-auto -->
  <button type="submit" class="btn ms-auto text-white" style="background-color: #4F88ED;"><i class="fa-solid fa-floppy-disk"></i> Guardar asistencias</button>
</div>

    <div class="container">
      <!-- Le decimos que nos emita los nuevos totales -->
              <AsistenciaAlumnos
  ref="asistenciaComponent"
  :alumnos="alumnosInscritos"
  :asistenciasPrevias="listaAsistencia"
  @updateCounts="handleUpdateCounts"
  @enviarAsistencias="recibirAsistencias"
/>

    </div>
  </div>
  </form>
</template>