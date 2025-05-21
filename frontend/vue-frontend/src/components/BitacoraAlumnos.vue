<script setup>
import { ref } from 'vue';
import axios from "axios";

const props = defineProps({
  alumnos: {
    type: Array,
    required: true
  },
  Actividad: {
    type: Array,
    required: true
  }
});

const alumnoSeleccionado = ref(null);

const abrirModal = (alumno) => {
  alumnoSeleccionado.value = alumno;
};

const alumnoEditable = ref({});

const abrirModalEdicion = (alumno) => {
  alumnoEditable.value = { ...alumno };
};

const guardarActu = async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      option: "updateBitacora",
      fecha: alumnoEditable.value.fecha,
      observaciones: alumnoEditable.value.observaciones,
      nombre_actividad: alumnoEditable.value.nombre_actividad,
      clave_bitacora: alumnoEditable.value.clave_bitacora


    });

    console.log("Respuesta del backend:", response.data);

    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Guardado Correctamente",
      showConfirmButton: false,
      timer: 1500
    });

    console.log("Alumno editado:", alumnoEditable.value);
  } catch (error) {
    console.error("Error al guardar los cambios:", error);
    alert("Ocurrió un error al guardar los cambios.");
  }
};


const guardarInsert = async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      option: "insertBitacora",
      clave_actividad: alumnoEditable.value.nombre_actividad,
      fecha: alumnoEditable.value.fecha,
      alumno: alumnoEditable.value.nocontrol,
      observaciones: alumnoEditable.value.observaciones
    });

    console.log("Respuesta del backend:", response.data);

    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Guardado Correctamente",
      showConfirmButton: false,
      timer: 1500
    });

    console.log("Alumno id :",   alumnoEditable.value.nombre_actividad,
      alumnoEditable.value.fecha,
      alumnoEditable.value.nocontrol,
      alumnoEditable.value.observaciones);
  } catch (error) {
    console.error("Error al guardar los cambios:", error);
    alert("Ocurrió un error al guardar los cambios.");
  }
};




</script>

<template>
  <div class="alumnos-inscritos row gx-3 gy-4">
    <div class="col-md-4" v-for="(alumno, index) in alumnos" :key="index">
      <div class="card shadow-sm rounded-4 border-0" :class="{
        'bg-m': alumno.sexo === 'M' && alumno.status !== 'inactivo',
        'bg-f': alumno.sexo === 'F' && alumno.status !== 'inactivo',
        'bg-gris': alumno.status === 'inactivo'
      }">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="icon-circle">
              <i class="fa-solid fa-user"></i>
            </div>
            <div class="ms-3">
              <h5 class="mb-1">{{ alumno.nombre }} {{ alumno.apellidos }}</h5>
              <p class="mb-0"><strong>Grupo:</strong> {{ alumno.clave_grupo }}</p>
            </div>
          </div>
          <div class="icon-stack text-end">
            <i class="fa-solid fa-file-pen" data-bs-toggle="modal" data-bs-target="#modalEditarAlumno"
              @click="abrirModalEdicion(alumno)"></i>
            <i class="fa-solid fa-circle-info" data-bs-toggle="modal" data-bs-target="#exampleModal"
              @click="abrirModal(alumno)"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Info -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Datos del Alumno</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p><strong>Nombre:</strong> {{ alumnoSeleccionado?.nombre }} {{ alumnoSeleccionado?.apellidos }}</p>
          <p><strong>No de control:</strong> {{ alumnoSeleccionado?.nocontrol }}</p>
          <p><strong>Grupo:</strong> {{ alumnoSeleccionado?.clave_grupo }}</p>
          <p><strong>Actividad:</strong> {{ alumnoSeleccionado?.nombre_actividad || 'Sin actividad' }}</p>
          <p><strong>Observaciones:</strong> {{ alumnoSeleccionado?.observaciones || 'Sin observaciones' }}</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEditarAlumno" tabindex="-1" aria-labelledby="modalEditarAlumnoLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalEditarAlumnoLabel">Editar Alumno</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent>
             <div class="mb-3">
              <label class="form-label"><strong>id:</strong> {{ alumnoEditable.nocontrol }}</label>
            </div>
            <div class="mb-3">
              <label class="form-label"><strong>Nombre:</strong> {{ alumnoEditable.nombre }}</label>
            </div>
            <div class="mb-3">
              <label class="form-label"> <strong>Apellidos:</strong> {{ alumnoEditable.apellidos }}</label>
            </div>
            <div class="mb-3">
              <label class="form-label"> <strong>Grupo: </strong>{{ alumnoEditable.clave_grupo }}</label>
            </div>
            <div class="mb-3">
              <label class="form-label"><strong>Sexo:</strong> {{ alumnoEditable.sexo }}</label>
            </div>
            <div class="mb-3">
              <label class="form-label"><strong>Actividad:</strong></label>
              <select class="form-select" v-model="alumnoEditable.nombre_actividad">
                <option disabled value=""> <strong>Actividad seleccionada: {{ alumnoEditable.nombre_actividad }}
                  </strong>
                </option>
                <option class="card-body col-md-2 mb-1" v-for="(Actividades, index) in Actividad" :key="index">
                  {{ Actividades.nombre_actividad }} </option>
                <!-- Agrega más opciones según tus actividades reales -->
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label"><strong>Observaciones:</strong></label>
              <textarea class="form-control" rows="3" v-model="alumnoEditable.observaciones"
                placeholder="Escribe observaciones..."></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label"><strong>Fecha:</strong></label>
              <input type="date" class="form-control" v-model="alumnoEditable.fecha" />
            </div>


          </form>
        </div>
        <div class="modal-footer" id="modalEditarAlumno" tabindex="-1" aria-labelledby="modalEditarAlumnoLabel">

          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" @click="guardarActu" v-if="alumnoEditable?.clave_bitacora">Guardar</button>
          <button type="button" class="btn btn-primary" @click="guardarInsert" v-else="alumnoEditable?.clave_bitacora=== 'null'">Guardar</button>



        </div>
      </div>
    </div>
  </div>
</template>


<style scoped>
.card-main {
  padding: 0.5rem;
}

.card {
  border-radius: 1.5rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
}

.bg-m {
  background-color: #ccefff; /* celeste pastel */
  color: #0c3c60;
}

.bg-f {
  background-color: #ffe0ef; /* rosa pastel */
  color: #5e184d;
}

.bg-gris {
  background-color: #f0f0f0;
  color: #3e3e3e;
}

.card-body {
  display: flex;
  align-items: center;
  padding: 1rem;
}

.icon-circle {
  height: 3.5rem;
  width: 3.5rem;
  border-radius: 50%;
  background-color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
  margin-right: 1rem;
  font-size: 1.5rem;
}

.icon-circle i {
  color: #7a7a7a;
}

.card-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.card-text {
  font-size: 0.95rem;
  margin-bottom: 0;
}

.icon-stack {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  margin-left: auto;
  cursor: pointer;
}

.icon-stack i {
  font-size: 1.2rem;
  transition: color 0.3s;
}

.icon-stack i:hover {
  color: #555;
}

@media (min-width: 768px) {
  .alumnos-inscritos {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
  }

  .card-main {
    width: 33.3333%;
  }
}

@media (max-width: 767px) {
  .card-main {
    width: 100%;
  }
}
</style>
