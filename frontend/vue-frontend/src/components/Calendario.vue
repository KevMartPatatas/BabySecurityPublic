<script setup>
import { ref } from 'vue';

const hoy = new Date();


const day = ref(null)
const month = ref(null)
const year = ref(null)

day.value = hoy.getDate();
month.value = hoy.getMonth()
year.value = hoy.getFullYear()



</script>


<template>
  <div class="calendario-container mt-3 me-4">

    <div class="calendario-div">
        <i class="fa-regular fa-calendar icono-calendario fs-3"></i>
    </div>

    <button class="calendario-boton">
      {{ day }}/{{ month }}/{{ year }}
    </button>
  </div>
</template>

<style scoped>
.icono-calendario {
  color: #ffffff;
}


.calendario-container {
  display: flex;
  align-items: center;
  width: fit-content;
  border: 1px solid #ccc;
  border-radius: 999px;
  overflow: hidden;
}

.calendario-boton {
  padding: 8px 12px;
  border: none;
  outline: none;
  border-radius: 999px 0 0 999px;
}

.calendario-div {
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
