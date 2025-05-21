<script setup>
import {ref} from "vue";
import {useUserStore} from "@/stores/user.js";
import router from "@/router/index.js";

const userName = ref('')
const password = ref('')
const errorMsg = ref(false)
const userStore = useUserStore()

function login() {
  // Validar el nombre de usuario
  const usernameRegex = /^[a-zA-Z][a-zA-Z0-9]{2,9}$/;
  if (!usernameRegex.test(userName.value.trim())) {
    errorMsg.value = "El nombre de usuario debe empezar con una letra, tener entre 3 y 10 caracteres y solo contener letras y números.";
    console.log(errorMsg.value)
    Swal.fire({
      icon: "error",
      title: "Error en nombre de usuario",
      text: errorMsg.value,
    });
    return;
  }
  // Validar la contraseña
  if (password.value.length < 5) {
    errorMsg.value = "La contraseña debe tener al menos 5 caracteres.";
    console.log(errorMsg.value)
    Swal.fire({
      icon: "error",
      title: "Error en la contraseña",
      text: errorMsg.value,
    });
    return;
  }
  userStore.login(userName.value, password.value)
}

</script>

<template>
  <!-- Contenedor del cuadro blanco centrado -->
  <div class="position-relative d-flex justify-content-center align-items-center w-100 h-100">
    <div class="bg-white p-5 rounded shadow w-75 h-75 bg-opacity-75">
      <!-- Aquí dividimos el cuadro en dos partes -->
      <div class="row h-100">
        <!-- Columna izquierda -->
        <div class="col-6 d-flex justify-content-center align-items-center">
          <img src="@/assets/logo_nombre.png" style="opacity: 100%;">
        </div>

        <!-- Columna derecha -->
        <div class="col-6 d-flex justify-content-center align-items-center">
          <!-- Div adicional dentro de la columna derecha -->
          <div class="bg-white w-100 h-100 p-3 rounded-3 shadow" style="margin: 10px; opacity: 100;">
            <!-- Contenido dentro de este div -->
            <form @submit.prevent="login" class="p-4">
              <p class="text-center mb-3 fs-5">Iniciar sesión</p>

              <!-- Campo de usuario -->
              <div class="mb-3">
                <input type="text" class="form-control" name="usuario" id="user-login"
                  placeholder="Usuario o correo"
                  ref="userLogin" v-model="userName" 
                  value="kevel" />
              </div>
            
              <!-- Campo de contraseña -->
              <div class="mb-3">
                <input type="password" class="form-control" name="contraseña" id="password-login"
                  placeholder="Contraseña"
                 ref="passwordLogin" v-model="password"
                 value="a52iPoamdF" />
              </div>
            
              <!-- Recordarme y enlace -->
              <div class="d-flex justify-content-between align-items-center mb-3">
                <label class="form-check-label">
                  <input class="form-check-input me-1" type="checkbox" name="recordar" />
                  Recuérdame
                </label>
                <a href="#">¿Olvidaste la contraseña?</a>
              </div>
            
              <!-- Botón de envío -->
              <button type="submit" class="btn btn-primary w-100 rounded-5">
                Iniciar Sesión
              </button>



            </form>

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
