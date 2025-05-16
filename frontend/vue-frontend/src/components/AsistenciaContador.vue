<script setup>
    defineProps({
        bgcolor: String,
        estado: String,
        contador: {
    type: [String, Number],
    required: true
  }

    })
</script>


<template>
    <div class="rounded px-4 py-1 text-white text-center me-3" :style="{backgroundColor: bgcolor}">
        <div class="fs-4 fw-bold">{{ contador }}</div>
        <div>{{ estado }}</div>
    </div>
</template>

<style scoped>
</style>