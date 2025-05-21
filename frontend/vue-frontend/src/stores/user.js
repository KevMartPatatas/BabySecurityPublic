import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from "axios";
import router from "@/router/index.js";

export const useUserStore = defineStore('user', () => {

        const user = ref(null)
        const nombre = ref(null)
        const matricula = ref(null)
        const password = ref(null)
        const userIsLoggedIn = ref(false)
        const grupo = ref(null)
        const rol = ref(null)

        async function login(username, password) {
            try {
                const response = await axios.post("http://localhost:80/api/Index.php", {
                        matricula: username,
                        password: password,
                        option: "login"
                });

                console.log(response.data)
                nombre.value = response.data.nombre
                matricula.value = response.data.matricula
                grupo.value = response.data.grupo
                rol.value = response.data.rol
                userIsLoggedIn.value = response.data.userIsLoggedIn;
                console.log(nombre.value, matricula.value, grupo.value, rol.value)
        
                // Redirigir al Home
                router.push({ name: "Inicio" });
            } catch (error) {
                console.error(`ERROR. Server Message: ${error.response?.data.message || "Unknown error"}`, error);
                Swal.fire({
                    icon: "error",
                    text: error.response?.data.message,
                  });
            }
        }

        function $reset() {
            this.userIsLoggedIn = false
        }

        return {nombre, rol, grupo, matricula, userIsLoggedIn, $reset, login }
    },
    {
        persist: true,
    }
)
