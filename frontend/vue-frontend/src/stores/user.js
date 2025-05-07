import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from "axios";
import router from "@/router/index.js";

export const useUserStore = defineStore('user', () => {

        const userId = ref(null);
        const userName = ref(null)
        const userEmail = ref(null)
        const userIsLoggedIn = ref(false)

        async function login(username, password) {
            try {
                const response = await axios.post('/user.php',{
                    params: {
                        username: username,
                        password: password,
                    }
                })

                console.log(response.data)
                this.userId = response.data.userId
                this.userName = response.data.userName
                this.userEmail = response.data.userEmail
                this.userIsLoggedIn = response.data.userIsLoggedIn
                router.push('/')

            } catch (error) {
                console.log(`ERROR. Server Message: ${error.response.data}. ${error}`)
            }
        }

        function $reset() {
            this.userId = null
            this.userName = null
            this.userEmail = null
            this.userIsLoggedIn = false
        }

        return { userId, userName, userEmail, userIsLoggedIn, $reset, login }
    },
    {
        persist: true,
    }
)
