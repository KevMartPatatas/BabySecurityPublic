<template>
  <div class="container-fluid bg-light min-vh-100 p-0">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-4">
      <div class="navbar-brand d-flex align-items-center gap-3">
        <span>Gestion</span>
      </div>
      <ul class="navbar-nav flex-row gap-3 ms-5">
        <li class="nav-item"><a class="nav-link text-white" href="#">Inicio</a></li>
        <li class="nav-item"><a class="nav-link active fw-bold" href="#">Gestion de niños</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Asistencia</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Bitácora</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Historial</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Personal</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Reportes</a></li>
      </ul>
      <button class="btn btn-warning ms-auto rounded-circle">
        <i class="bi bi-bell-fill"></i>
      </button>
    </nav>

    <!-- Buscador y Botón Generar Reporte -->
    <div class="d-flex justify-content-between align-items-center p-4">
      <div class="input-group w-50">
        <input v-model="busqueda" type="text" class="form-control" placeholder="Buscar..." />
        <button class="btn btn-outline-success">
          <i class="bi bi-search"></i>
        </button>
      </div>
      <button class="btn btn-outline-success" @click="generarPDF">
        <i class="bi bi-file-earmark-arrow-down me-1"></i> Generar reporte
      </button>
    </div>

    <!-- Contenido exportable -->
    <div id="reportePDF" class="container">
      <div class="row px-3">
        <div
          v-for="persona in filtradas"
          :key="persona.nombre"
          class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex"
        >
          <div
            :class="['card', 'shadow', 'border-0', 'h-100', persona.tipo === 'Docente' ? 'bg-light' : 'bg-white']"
          >
            <div class="card-body text-center">
              <img
                src="https://via.placeholder.com/100"
                class="rounded-circle mb-3 border border-2 border-primary"
                style="width: 100px; height: 100px;"
              />
              <h5 class="card-title">{{ persona.nombre }}</h5>
              <p class="card-text text-muted">
                {{ persona.tipo }}<br />
                {{ persona.grupo ? 'Grupo ' + persona.grupo : '' }}
              </p>
              <button class="btn btn-outline-primary btn-sm" @click="verDetalles(persona)">Ver más</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalPersona" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ personaSeleccionada.nombre }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p><strong>Tipo:</strong> {{ personaSeleccionada.tipo }}</p>
            <p v-if="personaSeleccionada.grupo"><strong>Grupo:</strong> {{ personaSeleccionada.grupo }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const busqueda = ref('')
const personaSeleccionada = ref({})

const personas = ref([
  { nombre: 'Kevin', tipo: 'Docente', grupo: 3 },
  { nombre: 'Jesus', tipo: 'Docente', grupo: 4 },
  { nombre: 'Carlos', tipo: 'Docente', grupo: 2 },
  { nombre: 'Pablo', tipo: 'Docente', grupo: 1 },
  { nombre: 'Maria Martinez', tipo: 'Directora' },
  { nombre: 'Sara López', tipo: 'Subdirectora' }
])

const filtradas = computed(() =>
  personas.value.filter(p =>
    p.nombre.toLowerCase().includes(busqueda.value.toLowerCase())
  )
)

function generarPDF() {
  const element = document.getElementById('reportePDF')
  html2pdf().from(element).save('reporte.pdf')
}

function verDetalles(persona) {
  personaSeleccionada.value = persona
  const modal = new bootstrap.Modal(document.getElementById('modalPersona'))
  modal.show()
}
</script>




