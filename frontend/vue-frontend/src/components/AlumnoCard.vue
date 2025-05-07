<template>
  <div class="card shadow-sm mb-3" :class="bgClass">
    <div class="card-body d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
          <i class="bi bi-person-fill text-secondary fs-4"></i>
        </div>
        <div class="text-white">
          <h6 class="mb-0 fw-bold">Maria Gloria</h6>
          <small>Status</small>
        </div>
      </div>
      <i class="bi bi-eye-fill text-white fs-5"></i>
    </div>
  </div>
</template>

<script setup>
defineProps({
  bgClass: {
    type: String,
    default: 'bg-danger' // puedes alternar con 'bg-info' o mas
  }
});
</script>
