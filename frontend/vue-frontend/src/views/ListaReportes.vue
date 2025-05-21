<script setup>
import NavBar from '@/components/NavBar.vue';
import Buscar from '@/components/Buscar.vue';
import ReportesCard from '@/components/ReportesCard.vue';
import { ref, onMounted } from 'vue'
import axios from "axios"

const lista = ref(null)

onMounted(async () => {
    try {
        const response = await axios.post("http://localhost:80/api/Index.php", {
            option: "getReportes"
        })

        lista.value = response.data.lista

        console.log(lista.value)


    } catch (error) {
        console.error(error)
    }
})
</script>

<template>
    <div class="container-fluid bg-light min-vh-100 p-0">
        <NavBar />

        <div class="d-flex justify-content-between align-items-center mb-3">
      <Buscar />
      <p class="text-center my-4 flex-grow-1 fs-2">Lista de reportes</p>
    </div>

    <div class="container-fluid bg-light min-vh-100 py-4 px-5" v-if="lista">
        <ReportesCard :reportes="lista" />
    </div>

    </div>
</template>