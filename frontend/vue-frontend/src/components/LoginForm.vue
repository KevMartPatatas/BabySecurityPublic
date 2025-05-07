<script setup>
import {ref} from "vue";
import {useUserStore} from "@/stores/user.js";
import router from "@/router/index.js";

const userName = ref('')
const password = ref('')
const errorMsg = ref(false)
const userStore = useUserStore()

function login() {
  userStore.login(userName.value, password.value)
}

</script>

<template>
  <!-- Contenedor del cuadro blanco centrado -->
  <div class="position-relative d-flex justify-content-center align-items-center w-100 h-100" style="opacity: 76%;">
    <div class="bg-white p-5 rounded shadow w-75 h-75">
      <!-- Aquí dividimos el cuadro en dos partes -->
      <div class="row h-100">
        <!-- Columna izquierda -->
        <div class="col-6 d-flex justify-content-center align-items-center">
          <img src="@/assets/logo_nombre.png" style="opacity: 100%;">
        </div>

        <!-- Columna derecha -->
        <div class="col-6 d-flex justify-content-center align-items-center">
          <!-- Div adicional dentro de la columna derecha -->
          <div class="bg-white w-100 h-100 p-3" style="margin: 10px; opacity: 100;">
            <!-- Contenido dentro de este div -->
            <p class="text-center">Formulario o más información aquí</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<style scoped>
.position-absolute {
    object-fit: cover; /* Asegura que la imagen cubra todo el fondo sin distorsionarse */
  }

  .bg-white {
    background-color: white; /* Fondo blanco para el cuadro */
  }
  
  .p-5 {
    padding: 2rem; /* Espaciado alrededor del contenido */
  }
  
  .rounded {
    border-radius: 10px; /* Bordes redondeados */
  }
  
  .shadow {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave para el cuadro */
  }
</style>