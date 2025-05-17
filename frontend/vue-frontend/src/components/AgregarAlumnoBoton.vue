<script setup>
  import { onMounted, ref } from 'vue';
  import { useUserStore } from '@/stores/user';
  import axios from "axios"
  const listaGrupos = ref([])

const nombre = ref(null)
const apellidos = ref(null)
const sexo = ref(null)
const grupo = ref(null)
const direccion = ref(null)
const tutor_nombre = ref(null)
const tutor_apellidos = ref(null)
const telefono = ref(null)
const nocontrol = ref(null)

  onMounted(async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      option: "getGrupos"
    })

    listaGrupos.value = response.data.lista

    if (Array.isArray(response.data.lista)) {
      listaGrupos.value = response.data.lista
    } else {
      listaGrupos.value = []
    }

    console.log("Lista de : ", listaGrupos.value)
  } catch (error) {
    console.error("Error al obtener lista de grupos: ", error)
    listaGrupos.value = []
  }
})

async function agregarAlumno() {
  console.log(nombre.value)
console.log(apellidos.value)
console.log(sexo.value)
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
      direccion: direccion.value,
      sexo: sexo.value,
      grupo: grupo.value,
      tutor_nombre: tutor_nombre.value,
      tutor_apellidos: tutor_apellidos.value,
      telefono: telefono.value,
      option: 'agregarAlumno'
    })

    console.log(response.data.mensaje)
  } catch (error) {
    console.log("Error en la insersion de alumnos frontend ",error)
  }
}

</script>


<template>
  <div class="search-container mt-3 me-4">

    <div class="search-button">
        <i class="fa-solid fa-plus icono-buscar fs-2"></i>
    </div>

    <button class="search-input" data-bs-toggle="modal" data-bs-target="#modalAlumnogregar">
      Agregar alumno
    </button>

<!-- Modal edición -->
<div
  class="modal fade"
  id="modalAlumnogregar"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-scrollable">
    <form @submit.prevent="agregarAlumno">
      <div
        class="modal-content border-0 rounded-4 shadow"
      >
        <div
          class="modal-header"
        >
          <h1 class="modal-title fs-5" id="exampleModalLabel">
            Agregar nuevo alumno
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
                v-model="nombre"
              />
            </div>

            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input
                type="text"
                class="form-control"
                id="apellidos"
                v-model="apellidos"
              />
            </div>

            <div class="mb-3">
              <label for="nocontrol" class="form-label">Numero de control</label>
              <input
                type="text"
                class="form-control"
                id="nocontrol"
                v-model="nocontrol"
              />
            </div>

            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <input
                type="text"
                class="form-control"
                id="direccion"
                v-model="direccion"
              />
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select
                  id="sexo"
                  class="form-select"
                  v-model="sexo"
                >
                  <option value="M">Masculino</option>
                  <option value="F">Femenino</option>
                </select>
              </div>

              <div class="col-md-4 mb-3">
  <label for="clave_grupo" class="form-label">Grupo</label>
  <select
    id="clave_grupo"
    class="form-select"
    v-model="grupo"
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
                v-model="tutor_nombre"
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
                v-model="tutor_apellidos"
              />
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input
                type="text"
                class="form-control"
                id="telefono"
                v-model="telefono"
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
  </div>
</template>

<style scoped>
.icono-buscar {
  color: #ffffff;
}


.search-container {
  display: flex;
  align-items: center;
  width: fit-content;
  border: 1px solid #ccc;
  border-radius: 999px;
  overflow: hidden;
}

.search-input {
  padding: 8px 12px;
  border: none;
  outline: none;
  border-radius: 999px 0 0 999px;
}

.search-button {
  background-color: #12564D;
  cursor: pointer;
  border-left: 1px solid #ccc;
  border-radius: 999px 0 0 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 45px;
  height: 45px;
}

</style>
