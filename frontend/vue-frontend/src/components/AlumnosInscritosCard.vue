<script setup>
import { ref } from 'vue';

// Define las propiedades del componente
const props = defineProps({
  alumnos: {
    type: Array,
    required: true
  }
});

// Propiedad reactiva para almacenar el alumno seleccionado
const alumnoSeleccionado = ref(null);

// Método para abrir el modal y almacenar el alumno seleccionado
const abrirModal = (alumno) => {
  alumnoSeleccionado.value = alumno;
};
</script>

<template>
  <div class="alumnos-inscritos row">
    <div v-for="(alumno, index) in alumnos" :key="index" class="col-md-4 mb-4">
      <div class="card w-100 h-100 rounded-4" :class="{'bg-m': alumno.sexo === 'm', 'bg-f': alumno.sexo === 'f'}">
        <div class="card-body d-flex align-items-center">
          <div class="icon-circle fs-3">
            <i class="fa-solid fa-user" style="color: #ababab;"></i>
          </div>
          <div class="ms-3 flex-grow-1">
            <h5 class="card-title">{{ alumno.nombre }} {{ alumno.apellidos }}</h5>
            <div class="d-flex justify-content-between align-items-center">
              <p class="card-text">{{ alumno.status }}</p>
              <i class="fa-solid fa-eye" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="abrirModal(alumno)"></i>
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
          <p><strong>Status:</strong> {{ alumnoSeleccionado?.status }}</p>
          <p v-if="alumnoSeleccionado?.sexo === 'f'"><strong>Sexo:</strong> femenino</p>
          <p v-else="alumnoSeleccionado?.sexo === 'm'"><strong>Sexo:</strong> masculino</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</template>





<style scoped>
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


</style>