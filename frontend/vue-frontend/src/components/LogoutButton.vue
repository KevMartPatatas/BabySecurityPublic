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
      class="rounded-md bg-red-500 mt-2 ml-2 text-white"
      @click="logout"
  >
    Logout
  </button>
</template>

<style scoped>

</style>