<script setup>
import { ref, onMounted } from 'vue';
import { useUserStore } from '@/stores/user';
import axios from "axios"

const userStore = useUserStore()
const rolSesion = userStore.rol
const listaGrupos = ref([])

const nombre = ref(null) 
const apellidos = ref(null)
const sexo = ref(null)
const status = ref(null)
const grupo = ref(null)
const direccion = ref(null)
const tutor_nombre = ref(null)
const tutor_apellidos = ref(null)
const telefono = ref(null)
const nocontrol = ref(null)


const props = defineProps({
  alumnos: {
    type: Array,
    required: true
  }
});

onMounted(async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      option: "getGrupos"
    })

    listaGrupos.value = response.data.lista

    if (Array.isArray(response.data.lista)) {
      listaGrupos.value = response.data.lista
    } else {
      listaGrupos.value = [] // Valor por defecto
    }

    console.log("Lista de : ", listaGrupos.value)
  } catch (error) {
    console.error("Error al obtener lista de grupos: ", error)
    listaGrupos.value = [] // fallback en caso de error
  }
})

// Propiedad reactiva para almacenar el alumno seleccionado
const alumnoSeleccionado = ref({
  nombre: '',
  apellidos: '',
  direccion: '',
  sexo: '',
  telefono: '',
  rol: '',
  matricula: ''
});

async function actualizarAlumno() {
nombre.value = alumnoSeleccionado.value.nombre
apellidos.value = alumnoSeleccionado.value.apellidos
sexo.value = alumnoSeleccionado.value.sexo
status.value = alumnoSeleccionado.value.status
grupo.value = alumnoSeleccionado.value.clave_grupo
direccion.value = alumnoSeleccionado.value.direccion
tutor_nombre.value = alumnoSeleccionado.value.tutor
tutor_apellidos.value = alumnoSeleccionado.value.tutor_apellidos
telefono.value = alumnoSeleccionado.value.telefono 
nocontrol.value = alumnoSeleccionado.value.nocontrol

console.log(nombre.value)
console.log(apellidos.value)
console.log(sexo.value)
console.log(status.value)
console.log(grupo.value)
console.log(tutor_nombre.value)
console.log(tutor_apellidos.value)
console.log(telefono.value)
console.log(direccion.value)
console.log(nocontrol.value)


try {
  const response = await axios.post('http://localhost:80/api/Index.php', {
    nocontrol: nocontrol.value,
    nombre: nombre.value,
    apellidos: apellidos.value,
    sexo: sexo.value,
    status: status.value,
    direccion: direccion.value,
    clave_grupo: grupo.value,
    tutor_nombre: tutor_nombre.value,
    tutor_apellidos: tutor_apellidos.value,
    telefono: telefono.value,
    option: "updateAlumnos"
  })

 Swal.fire({
  position: "top-end",
  icon: "success",
  title: response.data.mensaje,
  showConfirmButton: false,
  timer: 1500
});

  console.log(response.data.mensaje)
}
catch (error) {
  console.error("Error en la base de datos", error)
}
}

// Método para abrir el modal y almacenar el alumno seleccionado
const abrirModal = (alumno) => {
  alumnoSeleccionado.value = alumno;
};
</script>

<template>
  <div class="alumnos-inscritos row">
    <div
      v-for="(alumno, index) in alumnos"
      :key="index"
      class="col-md-4 mb-4"
    >
      <div
        class="card w-100 h-100 rounded-4 shadow-sm border-0 alumno-card"
        :class="{
          'bg-m': alumno.sexo === 'm' || alumno.sexo === 'M',
          'bg-f': alumno.sexo === 'f' || alumno.sexo === 'F'
        }"
      >
        <div class="card-body d-flex align-items-center">
          <div class="icon-circle">
            <i class="fa-solid fa-user fa-xl text-muted"></i>
          </div>
          <div class="ms-3 flex-grow-1">
            <h5 class="card-title mb-1">{{ alumno.nombre }} {{ alumno.apellidos }}</h5>
            <div class="d-flex justify-content-between align-items-center">
              <span class="badge bg-white text-dark px-3 py-1 rounded-pill">
                {{ alumno.status }}
              </span>
              <div class="icon-actions d-flex align-items-center gap-3">
  <i
    class="fa-solid fa-eye fa-lg icon-hover icon-eye"
    style="cursor: pointer;"
    data-bs-toggle="modal"
    data-bs-target="#exampleModal"
    @click="abrirModal(alumno)"
    title="Ver detalles"
  ></i>

  <i
    v-if="rolSesion === 'admin'"
    class="fa-solid fa-pen-to-square fa-lg icon-hover icon-edit"
    style="cursor: pointer;"
    data-bs-toggle="modal"
    data-bs-target="#exampleModalEdicion"
    @click="abrirModal(alumno)"
    title="Editar alumno"
  ></i>
</div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content border-0 rounded-4 shadow">
        <div class="modal-header"
     :class="{
       'modal-header-rosa': alumnoSeleccionado?.sexo === 'f' || alumnoSeleccionado?.sexo === 'F',
       'modal-header-azul': alumnoSeleccionado?.sexo === 'm' || alumnoSeleccionado?.sexo === 'M'
     }">
  <h1 class="modal-title fs-5" id="exampleModalLabel">Datos de {{alumnoSeleccionado?.nombre}}</h1>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
        <div class="modal-body">
  <ul class="list-unstyled">
    <li class="mb-3 d-flex align-items-start">
      <i class="fa-solid fa-user fa-fw me-2 text-primary"></i>
      <span><strong>Nombre:</strong> {{ alumnoSeleccionado?.nombre }} {{ alumnoSeleccionado?.apellidos }}</span>
    </li>
    <li class="mb-3 d-flex align-items-start">
      <i class="fa-solid fa-id-card fa-fw me-2 text-info"></i>
      <span><strong>Número de control:</strong> {{ alumnoSeleccionado?.nocontrol }}</span>
    </li>
    <li class="mb-3 d-flex align-items-start">
      <i class="fa-solid fa-check-circle fa-fw me-2 text-success"></i>
      <span><strong>Status:</strong> {{ alumnoSeleccionado?.status }}</span>
    </li>
    <li class="mb-3 d-flex align-items-start">
      <i class="fa-solid fa-users fa-fw me-2 text-warning"></i>
      <span><strong>Grupo:</strong> {{ alumnoSeleccionado?.clave_grupo }}</span>
    </li>
    <li class="mb-1 d-flex align-items-start">
      <i class="fa-solid fa-venus-mars fa-fw me-2 text-danger"></i>
      <span><strong>Sexo:</strong> {{ alumnoSeleccionado?.sexo === 'f' ? 'Femenino' : 'Masculino' }}</span>
    </li>
    <li class="mb-1 d-flex align-items-start">
      <i class="fa-solid fa-diamond-turn-right fa-fw me-2 text-danger"></i>
      <span><strong>Dirección:</strong> {{ alumnoSeleccionado?.direccion }}</span>
    </li>

    <!-- Datos del tutor -->
    <li class="mt-4 mb-3 fw-bold">Datos del Tutor</li>
    <li class="mb-3 d-flex align-items-start">
      <i class="fa-solid fa-user-tie fa-fw me-2 text-secondary"></i>
      <span><strong>Nombre:</strong> {{ alumnoSeleccionado?.tutor }} {{ alumnoSeleccionado?.tutor_apellidos }}</span>
    </li>
    <li class="mb-3 d-flex align-items-start">
      <i class="fa-solid fa-phone fa-fw me-2 text-secondary"></i>
      <span><strong>Teléfono:</strong> {{ alumnoSeleccionado?.telefono }}</span>
    </li>
  </ul>
</div>


        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal edición -->
<div
  class="modal fade"
  id="exampleModalEdicion"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-scrollable">
    <form @submit.prevent="actualizarAlumno">
      <div
        class="modal-content border-0 rounded-4 shadow"
        v-if="alumnoSeleccionado"
      >
        <div
          class="modal-header"
          :class="{
            'modal-header-rosa':
              alumnoSeleccionado?.sexo === 'f' ||
              alumnoSeleccionado?.sexo === 'F',
            'modal-header-azul':
              alumnoSeleccionado?.sexo === 'm' ||
              alumnoSeleccionado?.sexo === 'M',
          }"
        >
          <h1 class="modal-title fs-5" id="exampleModalLabel">
            Editar datos de {{ alumnoSeleccionado?.nombre }}
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>

        <div class="modal-body">
          <!-- Datos del Alumno -->
          <div class="mb-4">
            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
              Datos del Alumno
            </h6>

            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input
                type="text"
                class="form-control"
                id="nombre"
                v-model="alumnoSeleccionado.nombre"
              />
            </div>

            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input
                type="text"
                class="form-control"
                id="apellidos"
                v-model="alumnoSeleccionado.apellidos"
              />
            </div>

            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <input
                type="text"
                class="form-control"
                id="direccion"
                v-model="alumnoSeleccionado.direccion"
              />
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select
                  id="sexo"
                  class="form-select"
                  v-model="alumnoSeleccionado.sexo"
                >
                  <option value="M">Masculino</option>
                  <option value="F">Femenino</option>
                </select>
              </div>

              <div class="col-md-4 mb-3">
                <label for="status" class="form-label">Estatus</label>
                <select
                  id="status"
                  class="form-select"
                  v-model="alumnoSeleccionado.status"
                >
                  <option value="activo">Activo</option>
                  <option value="inactivo">Inactivo</option>
                </select>
              </div>

              <div class="col-md-4 mb-3">
  <label for="clave_grupo" class="form-label">Grupo</label>
  <select
    id="clave_grupo"
    class="form-select"
    v-model="alumnoSeleccionado.clave_grupo"
  >
    <option
      v-for="grupo in listaGrupos"
      :key="grupo.clave"
      :value="grupo.clave_grupo"
    >
      {{ grupo.clave_grupo }}
    </option>
  </select>
</div>
            </div>
          </div>

          <!-- Datos del Tutor -->
          <div>
            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
              Datos del Tutor
            </h6>

            <div class="mb-3">
              <label for="nombre-tutor" class="form-label"
                >Nombre del tutor</label
              >
              <input
                type="text"
                class="form-control"
                id="nombre-tutor"
                v-model="alumnoSeleccionado.tutor"
              />
            </div>

            <div class="mb-3">
              <label for="apellidos-tutor" class="form-label"
                >Apellidos del tutor</label
              >
              <input
                type="text"
                class="form-control"
                id="apellidos-tutor"
                v-model="alumnoSeleccionado.tutor_apellidos"
              />
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input
                type="text"
                class="form-control"
                id="telefono"
                v-model="alumnoSeleccionado.telefono"
              />
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-outline-secondary"
            data-bs-dismiss="modal"
          >
            Cerrar
          </button>
          <button type="submit" class="btn btn-primary">
            Guardar cambios
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

</template>

<style scoped>
/* Estilos de tarjetas */
.bg-m {
  background-color: #a3cef1;
  color: #1E3A5F;
}

.bg-f {
  background-color: #FFAED7;
  color: #5F1E58;
}

.icon-hover {
  transition: color 0.3s ease, transform 0.2s ease;
}

.icon-hover:hover {
  transform: scale(1.1);
}

/* Ícono de ver (lavanda pastel) */
.icon-eye {
  color: #7986CB;
}
.icon-eye:hover {
  color: #9FA8DA;
}

/* Ícono de editar (salmón pastel) */
.icon-edit {
  color: #FF8A65;
}
.icon-edit:hover {
  color: #FFAB91;
}

.card-body {
  display: flex;
  align-items: center;
  padding: 1.2rem;
}

.icon-circle {
  height: 3.5rem;
  width: 3.5rem;
  border-radius: 50%;
  background-color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.08);
}

.alumno-card {
  transition: transform 0.2s ease;
}
.alumno-card:hover {
  transform: translateY(-4px);
}

.hover-eye:hover {
  color: #4d94c4;
}

/* Modal */
.modal-content {
  background-color: #fefefe;
  border-radius: 1rem;
}
.modal-header {
  border-bottom: none;
}
.modal-footer {
  border-top: none;
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

</style>
