<script setup>
import axios from 'axios'
import { ref, computed } from 'vue'
import { useUserStore } from '@/stores/user'

const userStore = useUserStore()
const por = userStore.matricula
const hecho_por = userStore.nombre

const props = defineProps({
  docentes: {
    type: Array,
    required: true
  }
})

const nombreDocente = computed(() => {
  const docenteSeleccionado = props.docentes.find(docente => docente.matricula === para.value)
  return docenteSeleccionado
    ? `${docenteSeleccionado.nombre} ${docenteSeleccionado.apellidos}`
    : ''
})

const para = ref('')
const titulo = ref('')
const contenido = ref('')

async function guardarReporte() {
    console.log('Para (matrícula):', para.value)
    console.log('Para (nombre):', nombreDocente.value)
    console.log('Título:', titulo.value)
    console.log('Contenido:', contenido.value)
    console.log('Hecho por (matrícula):', por)
    console.log('Hecho por (nombre):', hecho_por)

    try {
        const response = await axios.post('http://localhost:80/api/Index.php', {
    para: para.value,
    para_nombre: nombreDocente.value, // Nombre completo del docente seleccionado
    por: por,
    por_nombre: hecho_por,
    titulo: titulo.value,
    contenido: contenido.value,
    option: "subirReporte"
})


        console.log(response.data)

    } catch (error) {
        console.error("Error al subir el reporte: ", error)
    }
}

</script>

<template>
    <div class="card pastel-card border-0 shadow-sm h-100" style="background-color: #ffe5ec;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-dark">Crear Reporte</h5>
              <p class="card-text text-secondary">Genera un nuevo reporte para la persona seleccionada o para un grupo específico.</p>
              <button class="btn pastel-btn" style="background-color: #ffb3c1; color: white;" data-bs-toggle="modal" data-bs-target="#modalCrearReporte">Crear</button>
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
            <label class="form-label">👩‍🎓 Reporte para: </label>
            <select id="para" class="form-select" v-model="para">
                <option v-for="docente in docentes" :value="docente.matricula" :key="docente.matricula">
                    {{ docente.nombre }} {{ docente.apellidos }} - {{ docente.matricula }}
                </option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">👩‍🎓 Titulo del reporte</label>
            <input type="text" class="form-control" v-model="titulo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">📝 Contenido</label>
            <textarea class="form-control" rows="4" v-model="contenido" required></textarea>
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
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
  transform: translateY(-5px);
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
