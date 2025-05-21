<script setup>
const props = defineProps({
  reportes: {
    type: Array,
    required: true
  }
});
</script>

<template>
  <div class="row g-4">
    <div
      class="col-md-6 col-lg-4"
      v-for="(reporte, index) in reportes"
      :key="index"
    >
      <div class="card pastel-card shadow-sm h-100 border-0">
        <div class="card-header bg-header text-white rounded-top">
          <h5 class="mb-0 fw-bold">
            <i class="fas fa-file-alt me-2"></i>{{ reporte.titulo }}
          </h5>
        </div>
        <div class="card-body bg-body d-flex flex-column">
          <p class="text-muted mb-2">
            <i class="fas fa-user me-1 text-primary"></i>
            <strong>De:</strong> {{ reporte.por_nombre }}
          </p>
          <p class="text-muted mb-2">
            <i class="fas fa-user-tag me-1 text-success"></i>
            <strong>Para:</strong> {{ reporte.para_nombre }}
          </p>
          <p class="card-text text-secondary mb-3" style="min-height: 70px;">
            {{ reporte.contenido }}
          </p>
          <div class="d-flex justify-content-between align-items-center mt-auto">
            <small class="text-muted">
              <i class="fas fa-calendar-alt me-1"></i>{{ reporte.fecha }}
              <i class="fas fa-clock ms-3 me-1"></i>{{ reporte.hora }}
            </small>
            <button class="btn btn-pastel rounded-pill btn-sm">
              <i class="fas fa-eye me-1"></i> Ver más
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="reportes.length === 0" class="text-center text-secondary">
      No hay reportes disponibles.
    </div>
  </div>
</template>

<style scoped>
.pastel-card {
  border-radius: 1.5rem;
  overflow: hidden;
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  background-color: #fff0f3;
}
.pastel-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
}

.bg-header {
  background-color: #ffc2d1;
  padding: 1rem 1.25rem;
}

.bg-body {
  background-color: #fffafc;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.btn-pastel {
  background-color: #ffb3c1;
  color: white;
  border: none;
  font-weight: 500;
  transition: background-color 0.3s ease;
}
.btn-pastel:hover {
  background-color: #ff94aa;
}
</style>
