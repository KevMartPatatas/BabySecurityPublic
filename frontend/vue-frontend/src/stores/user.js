import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from "axios";
import router from "@/router/index.js";

export const useUserStore = defineStore('user', () => {

        const user = ref(null)
        const nombre = ref(null)
        const grupo = ref(null)
        const password = ref(null)
        const userIsLoggedIn = ref(false)

        async function login(username, password) {
            try {
                const response = await axios.post("http://localhost:80/api/Index.php", {
                        matricula: username,
                        password: password,
                        option: "login"
                });

                console.log(response.data)
                user.value = response.data.matricula
                nombre.value = response.data.nombre
                grupo.value = response.data.grupo
                userIsLoggedIn.value = response.data.userIsLoggedIn;
                console.log(user.value, nombre.value, grupo.value)
        
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

        return {user, nombre, grupo, userIsLoggedIn, $reset, login }
    },
    {
        persist: true,
    }
)
