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

const guardarCambios = () => {
  console.log("Alumno editado:", alumnoEditable.value);
};

const guardarCambioss = async () => {
  try {
    const response = await axios.post("http://localhost:80/api/Index.php", {
      option: "updateBitacora",
      fecha: alumnoEditable.value.fecha,
      observaciones: alumnoEditable.value.observaciones,
      clave_bitacora:alumnoEditable.value.clave_bitacora
    });

    console.log("Respuesta del backend:", response.data);

    Swal.fire({
  position: "top-end",
  icon: "success",
  title: "Guardado Correctamente",
  showConfirmButton: false,
  timer: 1500});

 
  } catch (error) {
    console.error("Error al guardar los cambios:", error);
    alert("Ocurrió un error al guardar los cambios.");
  }
};



</script>

<template>
  <div class="alumnos-inscritos row">
    <div class="card-main col-md-2 mb-1" v-for="(alumno, index) in alumnos" :key="index">

      <div class="card w-80 h-100 rounded-4" :class="{
        'bg-m': alumno.sexo === 'M' && alumno.status !== 'inactivo',
        'bg-f': alumno.sexo === 'F' && alumno.status !== 'inactivo',
        'bg-gris': alumno.status === 'inactivo'
      }">

        <div class="card-body d-flex align-items-center">

          <div class="icon-circle fs-4">
            <i class="fa-solid fa-user" style="color: #ababab;"></i>
          </div>
          <div class="ms-4">
            <h5 class="card-title">{{ alumno.nombre }} {{ alumno.apellidos }}</h5>

            <div class="d-flex justify-content-between align-items-center ">
              <p class="card-text"> <strong>Grupo: </strong>{{ alumno.clave_grupo }}</p>
            </div>

          </div>
          <div class="ms-3 flex-grow-1">

            <div class="icon-stack">
              <i class="fa-solid fa-file-pen" style="cursor: pointer;" data-bs-toggle="modal"
                data-bs-target="#modalEditarAlumno" @click="abrirModalEdicion(alumno)"></i>
              <i class="fa-solid fa-circle-info" style="cursor: pointer;" data-bs-toggle="modal"
                data-bs-target="#exampleModal" @click="abrirModal(alumno)"></i>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Datos del Alumno</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Mostrar los datos del alumno seleccionado -->
          <p><strong>Nombre:</strong> {{ alumnoSeleccionado?.nombre }} {{ alumnoSeleccionado?.apellidos }}</p>
          <p><strong>No de control:</strong> {{ alumnoSeleccionado?.nocontrol }}</p>
          <p><strong>Grupo:</strong> {{ alumnoSeleccionado?.clave_grupo }}</p>
          <p><strong>Actividad:</strong> {{ alumnoSeleccionado?.nombre_actividad || 'sin actividad' }}</p>
          <p><strong>Observaciones:</strong> {{ alumnoSeleccionado?.observaciones || 'Sin observaciones' }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de edición -->
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
                  {{ Actividades.nombre_actividad}} </option>
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
        <div class="modal-footer" id="modalEditarAlumno"  tabindex="-1" aria-labelledby="modalEditarAlumnoLabel" >
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" @click="guardarCambioss" >Guardar</button>
        </div>
      </div>
    </div>
  </div>

</template>





<style scoped>
.bg-gris {
  background-color: #CCCCCC;
  color: #1E1E1E;
  border: 1px solid #999999;
}

.card-main {
  margin: 40px;
  /* reduce esto si es necesario */
  padding: 1px;

}

.bg-m {
  background-color: #80CEE1;
  color: #1E3A5F;
  border: 1px solid;
}

.bg-f {
  background-color: #EA899A;
  color: #5F1E58;
}

.card-body {
  display: flex;
  align-items: center;
}

.icon-circle {
  height: 4rem;
  width: 4rem;
  border-radius: 50%;
  background-color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  margin-right: 10px;
}

.ms-3 {
  margin-left: 10px;
}

.ms-4 {
  margin-left: 10px;
}

.flex-grow-1 {
  flex-grow: 1;
}

.d-flex {
  display: flex;
}

.justify-content-between {
  justify-content: space-between;
}

.align-items-center {
  align-items: center;
}

.icon-stack {
  display: flex;
  flex-direction: column;
  /* Alinea los íconos verticalmente */
  align-items: center;
  /* Centra los íconos horizontalmente */
  gap: 0.8rem;
  /* Espacio entre íconos (ajustable) */
  margin-left: auto;
  /* Mueve a la derecha si está dentro de un contenedor flex */
  margin-right: 1px;
  /* Separación desde el borde derecho */
  padding: 0.2rem;
  /* Espaciado interno */
  background-color: transparent;
  /* Puedes darle un fondo si quieres */
}
</style>