<script setup>
    import { onMounted, ref } from 'vue'
    import axios from "axios"
    const listaGrupos = ref([])

    const nombre = ref('')
    const apellidos = ref('')
    const matricula = ref('')
    const password = ref('')
    const rol = ref('')
    const grupo = ref('')
    const direccion = ref('')
    const sexo = ref('')
    const telefono = ref('')
    

    onMounted(async () => {
        try {
          const response = await axios.post("http://localhost:80/api/Index.php", {
            option: "getGrupos"
          })
      
          listaGrupos.value = response.data.lista
      
          // Verificamos que exista y sea array
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

async function agregarDocente() {
    console.log(nombre.value)
    console.log(apellidos.value)
    console.log(matricula.value)
    console.log(password.value)
    console.log(rol.value)
    console.log(grupo.value)
    console.log(direccion.value)
    console.log(sexo.value)
    console.log(telefono.value)

    try {
        const response = await axios.post('http://localhost:80/api/Index.php', {
            nombre: nombre.value,
            apellidos: apellidos.value,
            matricula: matricula.value,
            password: password.value,
            rol: rol.value,
            grupo: grupo.value,
            direccion: direccion.value,
            sexo: sexo.value,
            telefono: telefono.value,
            option: "agregarDocente"
        })

        console.log(response.data)
    } catch (error) {
        console.error('Error en: ', error)
    }


}
</script>


<template>
  <div class="search-container mt-3 me-4">

    <div class="search-button">
        <i class="fa-solid fa-plus icono-buscar fs-2"></i>
    </div>

    <button class="search-input" data-bs-toggle="modal" data-bs-target="#modalDocenteAgregar">
      Agregar Personal
    </button>

    <div
    class="modal fade"
    id="modalDocenteAgregar"
    tabindex="-1"
    aria-labelledby="modalDocenteLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
  >
    <div class="modal-dialog">
      <form @submit.prevent="agregarDocente">
      <div class="modal-content border-0 rounded-4 shadow">
        <div
          class="modal-header"
        >
          <h1 class="modal-title fs-5" id="modalDocenteLabel">Agregar nuevo docente</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input
                type="text"
                class="form-control"
                id="nombreDocente"
                v-model="nombre"
              />
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input
                type="text"
                class="form-control"
                id="apellidosDocente"
                v-model="apellidos"
              />
            </div>
            <div class="mb-3">
              <label for="matricula" class="form-label">Matricula</label>
              <input
                type="text"
                class="form-control"
                id="matricula"
                v-model="matricula"
              />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input
                type="text"
                class="form-control"
                id="password"
                v-model="password"
              />
            </div>
            <div class="mb-3">
              <label for="rolDocente" class="form-label">Rol</label>
              <select
                id="rolDocente"
                class="form-select"
                v-model="rol"
              >
                <option value="admin">ADMINISTRADOR</option>
                <option value="docente">DOCENTE</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="rol" class="form-label">Grupo</label>
              <select
                id="rolLabel"
                class="form-select"
                v-model="grupo"
              >
                <option
      v-for="grupos in listaGrupos"
      :key="grupos.clave"
      :value="grupos.clave_grupo"
    >
      {{ grupos.clave_grupo }}
    </option>
              </select>
            </div>
            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <input
                type="text"
                class="form-control"
                id="direccionDocente"
                v-model="direccion"
              />
            </div>
            <div class="mb-3">
              <label for="sexo" class="form-label">Sexo</label>
              <select
                id="sexoDocente"
                class="form-select"
                v-model="sexo"
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
                id="telefonoDocente"
                v-model="telefono"
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
