<script setup>
defineProps({
  bgcolor: String,
  img: String,
  titulo: String,
  textcolor: String
})
</script>

<template>
  <div
    class="card custom-card p-3 align-items-center shadow-sm me-5"
    :style="{ backgroundColor: bgcolor, color: textcolor }"
  >
    <img :src="img" alt="Imagen" class="card-img mb-3" />
    <div class="card-body p-0">
      <p class="card-text fs-4 fw-semibold text-center">{{ titulo }}</p>
    </div>
  </div>
</template>

<style scoped>
.custom-card {
  width: 15rem;
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 1rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.custom-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.card-img {
  width: 80%;
  object-fit: contain;
  border-radius: 0.5rem;
}
</style>
