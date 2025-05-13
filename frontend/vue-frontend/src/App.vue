<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Dashboard from "@/views/Dashboard.vue";

</script>

<template>
  <RouterView />
</template>

<style scoped>
/* Este estilo aplica solo a este componente (App.vue) */
body {
  background-color: #F1F1F1; /* El color de fondo que deseas */
  margin: 0;
  padding: 0;
  height: 100%;
}
</style>