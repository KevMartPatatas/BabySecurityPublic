<script setup>
    defineProps({
        bgcolor: String,
        img: String,
        titulo: String,
        textcolor: String
    })
</script>

<template>
    <div class="card p-2 align-items-center shadow me-5" style="width: 15rem; border: 1px solid;" :style="{backgroundColor: bgcolor, color: textcolor}">
        <img :src="img" alt="Imagen grande" width="80%">
        <div class="card-body">
            <p class="card-text fs-3 text-center">{{ titulo }}</p>
        </div>
    </div>
</template>