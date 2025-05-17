<script setup>
import { useUserStore } from "@/stores/user.js";
import router from "@/router/index.js";
const userStore = useUserStore();

function logout() {
  userStore.$reset()
  router.push('/login')

}
</script>

<template>
  <button
    class="btn-logout"
    @click="logout"
  >
    Logout
  </button>
</template>

<style scoped>
.btn-logout {
  background: #f87171; /* rojo pastel suave */
  color: white;
  font-weight: 600;
  padding: 0.5rem 1.2rem;
  border-radius: 0.5rem;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
  box-shadow: 0 4px 8px rgba(248, 113, 113, 0.4);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.btn-logout:hover {
  background: #ef4444; /* rojo un poco más intenso */
  transform: scale(1.05);
  box-shadow: 0 6px 12px rgba(239, 68, 68, 0.6);
}

.btn-logout:active {
  transform: scale(0.95);
  box-shadow: 0 3px 6px rgba(239, 68, 68, 0.4);
}
</style>
