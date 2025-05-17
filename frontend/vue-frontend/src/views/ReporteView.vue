<script setup>
import { ref, computed, onMounted } from 'vue'

const busqueda = ref('')
const fecha = ref('2025-04-01')
const personaSeleccionada = ref({})
import NavBar from '@/components/NavBar.vue'
import Buscar from '@/components/Buscar.vue'
import GenerarReporte from '@/components/GenerarReporte.vue'
import axios from "axios"

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

Swal.fire({
  title: "Pagina en desarrollo",
  width: 600,
  padding: "3em",
  color: "#716add",
  backdrop: `
    rgba(0,0,123,0.4)
    url("https://i.pinimg.com/originals/ed/01/22/ed012259c25cd0a787064216db37c22d.gif")
    left top
    no-repeat
  `
});
</script>


<template> 
  <div class="container-fluid bg-light min-vh-100 p-0">
    <!-- Navbar -->
    <NavBar />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <Buscar />
      <p class="text-center my-4 flex-grow-1 fs-2">Reportes</p>
      <GenerarReporte />
    </div>

    <!-- Contenido principal -->
    <div class="container-fluid bg-light min-vh-100 py-4 px-5">
      <div class="row g-4">
        <!-- Tarjeta: Crear Reporte -->
        <div class="col-md-4">
          <div class="card pastel-card border-0 shadow-sm h-100" style="background-color: #ffe5ec;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-dark">Crear Reporte</h5>
              <p class="card-text text-secondary">Genera un nuevo reporte para la persona seleccionada o para un grupo específico.</p>
              <button class="btn pastel-btn" style="background-color: #ffb3c1; color: white;" data-bs-toggle="modal" data-bs-target="#modalCrearReporte">Crear</button>
            </div>
          </div>
        </div>

        <!-- Tarjeta: Leer y Editar Reportes -->
        <div class="col-md-4">
          <div class="card pastel-card border-0 shadow-sm h-100" style="background-color: #d0f4de;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-dark">Leer y Editar Reportes</h5>
              <p class="card-text text-secondary">Consulta los reportes anteriores y realiza modificaciones si es necesario.</p>
              <button class="btn pastel-btn" style="background-color: #95d5b2; color: white;">Ver Reportes</button>
            </div>
          </div>
        </div>

        <!-- Tarjeta: Eliminar Reportes -->
        <div class="col-md-4">
          <div class="card pastel-card border-0 shadow-sm h-100" style="background-color: #cdeaff;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-dark">Eliminar Reportes</h5>
              <p class="card-text text-secondary">Borra reportes que ya no sean necesarios o estén desactualizados.</p>
              <button class="btn pastel-btn" style="background-color: #90e0ef; color: white;">Eliminar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="modalCrearReporte" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">🌼 Nuevo Reporte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Formulario -->
        <form @submit.prevent="guardarReporte">
          <div class="mb-3">
            <label class="form-label">👩‍🎓 Nombre del reporte</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">📝 Contenido</label>
            <textarea class="form-control" rows="4" required></textarea>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success">💾 Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</template>

<style scoped>
.pastel-card {
  border-radius: 1rem;
  transition: transform 0.2s ease-in-out;
}
.pastel-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}
.pastel-btn {
  border-radius: 2rem;
  padding: 0.5rem 1.5rem;
  font-weight: 500;
}

.modal-content {
  background: #fefefe;
  border-radius: 1.5rem;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.modal-header {
  background: #ffe5ec; /* verde pastel */
  color: #fff;
  border-top-left-radius: 1.5rem;
  border-top-right-radius: 1.5rem;
}

.modal-body {
  background: #fdfdfd;
  padding: 2rem;
}

.form-label {
  font-weight: 600;
  color: #6c757d;
}

.form-control {
  border-radius: 0.75rem;
  border: 1px solid #ced4da;
  background-color: #f8f9fa;
  color: #495057;
}

.form-control:focus {
  border-color: #86c5b8;
  box-shadow: 0 0 0 0.2rem rgba(167, 215, 197, 0.25);
}

.btn-success {
  background-color: #ffe5ec;
  border: none;
  font-weight: 600;
  padding: 0.6rem 1.5rem;
  border-radius: 1rem;
}

.btn-success:hover {
  background-color: #ffb3c1;
}
</style>
