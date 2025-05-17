<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/stores/user';
import axios from "axios"

const userStore = useUserStore()
const rolSesion = userStore.rol

const nombre = ref('')
const apellidos = ref('')
const direccion = ref('')
const sexo = ref('')
const telefono = ref('')
const rol = ref('')
const matricula = ref('')

console.log(rolSesion)

const props = defineProps({
  docentes: {
    type: Array,
    required: true
  }
});

const docenteSeleccionado = ref({
  nombre: '',
  apellidos: '',
  direccion: '',
  sexo: '',
  telefono: '',
  rol: '',
  matricula: ''
});

const abrirModal = (docente) => {
  docenteSeleccionado.value = docente;
};


async function actualizarPersonal() {
  nombre.value = docenteSeleccionado.value.nombre
  apellidos.value = docenteSeleccionado.value.apellidos
  direccion.value = docenteSeleccionado.value.direccion
  sexo.value = docenteSeleccionado.value.sexo
  telefono.value = docenteSeleccionado.value.telefono
  rol.value = docenteSeleccionado.value.rol
  matricula.value = docenteSeleccionado.value.matricula

  console.log(nombre.value)
  console.log(apellidos.value)
  console.log(direccion.value)
  console.log(sexo.value)
  console.log(telefono.value)
  console.log(rol.value)
  console.log(matricula.value)

  try {
    const response =  await axios.post('http://localhost:80/api/Index.php', {
      nombre: nombre.value,
      apellidos: apellidos.value,
      direccion: direccion.value,
      sexo: sexo.value,
      telefono: telefono.value,
      rol: rol.value,
      matricula: matricula.value,
      option: "updatePersonal"
    })

    console.log(response.data.mensaje)
  } catch (error) {
    console.error(error)
  }

}
</script>

<template>
  <div class="row">
    <div
      v-for="(docente, index) in docentes"
      :key="index"
      class="col-12 col-md-6 col-lg-4 mb-4"
    >
      <div
        class="card personal-card card-docente shadow rounded-4"
        :class="{
          'borde-femenino': docente.sexo === 'F' || docente.sexo === 'f',
          'borde-masculino': docente.sexo === 'M' || docente.sexo === 'm'
        }"
      >
        <div class="card-body d-flex align-items-start">
          <div
            class="avatar-icon"
            :class="{
              'avatar-femenino': docente.sexo === 'F' || docente.sexo === 'f',
              'avatar-masculino': docente.sexo === 'M' || docente.sexo === 'm'
            }"
          >
            <i class="fa-solid fa-user-tie"></i>
          </div>
          <div class="ms-3 flex-grow-1">
            <h5 class="card-title mb-1">
              {{ docente.nombre }} {{ docente.apellidos }} <span v-if="docente.rol === 'admin'"><i class="fa-solid fa-user-shield"></i></span>
            </h5>
            <p class="text-muted mb-1">
              <i class="fa-solid fa-id-badge me-1"></i> <strong>Matrícula:</strong> {{ docente.matricula }}
            </p>
            <p class="small mb-1">
              <i class="fa-solid fa-map-marker-alt me-1"></i> <strong>Dirección:</strong> {{ docente.direccion }}
            </p>
            <p class="small mb-1">
              <i class="fa-solid fa-venus-mars me-1"></i> <strong>Sexo:</strong>
              {{ docente.sexo === 'M' ? 'Masculino' : docente.sexo === 'F' ? 'Femenino' : docente.sexo }}
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <p class="small mb-0">
                <i class="fa-solid fa-phone me-1"></i> <strong>Contacto:</strong>
                <span v-if="docente.telefono">{{ docente.telefono }}</span>
                <span v-else class="text-muted">No disponible</span>
              </p>
              <i
                class="fa-solid fa-eye view-icon action-icon"
                style="cursor: pointer;"
                data-bs-toggle="modal"
                data-bs-target="#modalDocente"
                @click="abrirModal(docente)"
              ></i>
              <i 
              v-if="rolSesion === 'admin'"
                class="fa-solid fa-pen-to-square edit-icon action-icon"
                style="cursor: pointer;"
                data-bs-toggle="modal"
                data-bs-target="#modalDocenteEditar"
                @click="abrirModal(docente)"
              ></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div
    class="modal fade"
    id="modalDocente"
    tabindex="-1"
    aria-labelledby="modalDocenteLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
  >
    <div class="modal-dialog">
      <div class="modal-content border-0 rounded-4 shadow" v-if="docenteSeleccionado">
        <div
          class="modal-header"
          :class="{
            'modal-header-rosa': docenteSeleccionado?.sexo === 'f' || docenteSeleccionado?.sexo === 'F',
            'modal-header-azul': docenteSeleccionado?.sexo === 'm' || docenteSeleccionado?.sexo === 'M'
          }"
        >
          <h1 class="modal-title fs-5" id="modalDocenteLabel">Datos del Docente</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <ul class="list-unstyled">
            <li class="mb-3 d-flex align-items-start">
              <i class="fa-solid fa-user-tie fa-fw me-2 text-primary"></i>
              <span><strong>Nombre:</strong> {{ docenteSeleccionado?.nombre }} {{ docenteSeleccionado?.apellidos }}</span>
            </li>
            <li class="mb-3 d-flex align-items-start">
              <i class="fa-solid fa-id-badge fa-fw me-2 text-info"></i>
              <span><strong>Matrícula:</strong> {{ docenteSeleccionado?.matricula }}</span>
            </li>
            <li class="mb-3 d-flex align-items-start">
              <i class="fa-solid fa-map-marker-alt fa-fw me-2 text-warning"></i>
              <span><strong>Dirección:</strong> {{ docenteSeleccionado?.direccion }}</span>
            </li>
            <li class="mb-3 d-flex align-items-start">
              <i class="fa-solid fa-venus-mars fa-fw me-2 text-danger"></i>
              <span><strong>Sexo:</strong> {{ docenteSeleccionado?.sexo === 'f' ? 'Femenino' : 'Masculino' }}</span>
            </li>
            <li class="mb-1 d-flex align-items-start">
              <i class="fa-solid fa-phone fa-fw me-2 text-success"></i>
              <span><strong>Teléfono:</strong> {{ docenteSeleccionado?.telefono || 'No disponible' }}</span>
            </li>
          </ul>
        </div>
        <div class="modal-footer">
  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>
      </div>
    </div>
  </div>

  <div
    class="modal fade"
    id="modalDocenteEditar"
    tabindex="-1"
    aria-labelledby="modalDocenteLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
  >
    <div class="modal-dialog">
      <form @submit.prevent="actualizarPersonal">
      <div class="modal-content border-0 rounded-4 shadow" v-if="docenteSeleccionado">
        <div
          class="modal-header"
          :class="{
            'modal-header-rosa': docenteSeleccionado?.sexo === 'f' || docenteSeleccionado?.sexo === 'F',
            'modal-header-azul': docenteSeleccionado?.sexo === 'm' || docenteSeleccionado?.sexo === 'M'
          }"
        >
          <h1 class="modal-title fs-5" id="modalDocenteLabel">Editar datos del docente</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input
                type="text"
                class="form-control"
                id="nombre"
                v-model="docenteSeleccionado.nombre"
              />
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input
                type="text"
                class="form-control"
                id="apellidos"
                v-model="docenteSeleccionado.apellidos"
              />
            </div>
            <div class="mb-3">
              <label for="rol" class="form-label">Rol</label>
              <select
                id="rol"
                class="form-select"
                v-model="docenteSeleccionado.rol"
              >
                <option value="admin">ADMINISTRADOR</option>
                <option value="docente">DOCENTE</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <input
                type="text"
                class="form-control"
                id="direccion"
                v-model="docenteSeleccionado.direccion"
              />
            </div>
            <div class="mb-3">
              <label for="sexo" class="form-label">Sexo</label>
              <select
                id="sexo"
                class="form-select"
                v-model="docenteSeleccionado.sexo"
              >
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input
                type="text"
                class="form-control"
                id="telefono"
                v-model="docenteSeleccionado.telefono"
              />
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.action-icon {
  cursor: pointer;
  font-size: 1.2rem;
  margin: 0 5px;
  padding: 8px;
  border-radius: 50%;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.personal-card {
  background: #f9f9fd;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.personal-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
}

.avatar-icon {
  background-color: #dceeff;
  color: #2274a5;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  aspect-ratio: 1 / 1;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  flex-shrink: 0;
}

.card-title {
  font-weight: 600;
  font-size: 1.1rem;
}

.text-muted {
  color: #666 !important;
}

.card-docente {
  border-left: 6px solid #a3cef1;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.borde-femenino {
  border-left: 6px solid #f4a3c2; /* rosa pastel */
}


.card-docente:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 20px rgba(163, 206, 241, 0.3);
}

.avatar-femenino {
  background-color: #ffe0ec; /* fondo rosa claro */
  color: #d63384; /* fucsia oscuro */
}

.avatar-masculino {
  background-color: #dceeff; /* fondo azul claro */
  color: #2274a5; /* azul oscuro */
}

.modal-header-rosa {
  background-color: #FFAED7;
  color: #5F1E58;
  border-top-left-radius: 0.75rem;
  border-top-right-radius: 0.75rem;
}

.modal-header-azul {
  background-color: #a3cef1;
  color: #1E3A5F;
  border-top-left-radius: 0.75rem;
  border-top-right-radius: 0.75rem;
}

/* Estilo general para todos los íconos */
i.fa-solid {
  transition: color 0.3s ease, transform 0.2s ease;
  vertical-align: middle;
}

/* Ícono de ver (ojo) */
.view-icon {
  color: #0d6efd;
  background-color: #e7f1ff;
}

.view-icon:hover {
  background-color: #0d6efd;
  color: white;
  transform: scale(1.1);
}

/* Íconos en el modal (color específico por tipo) */
.modal-body .fa-user-tie {
  color: #007bff; /* azul */
}

.modal-body .fa-id-badge {
  color: #17a2b8; /* cyan */
}

.modal-body .fa-map-marker-alt {
  color: #ffc107; /* amarillo */
}

.modal-body .fa-venus-mars {
  color: #e83e8c; /* rosa */
}

.modal-body .fa-phone {
  color: #28a745; /* verde */
}

/* Íconos alineados en la lista del modal */
.modal-body li i.fa-solid {
  font-size: 1.1rem;
  min-width: 20px;
  text-align: center;
  margin-top: 2px;
}

/* Ícono de editar (lápiz) */
.edit-icon {
  color: #ffc107;
  background-color: #fff8e1;
}

.edit-icon:hover {
  background-color: #ffc107;
  color: black;
  transform: scale(1.1);
}
</style>
