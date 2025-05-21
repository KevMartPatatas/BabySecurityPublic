<script setup>
import NavBar from '@/components/NavBar.vue';
</script>

<template>
  <div class="container-fluid bg-light min-vh-100 p-0">
    <NavBar />

    <div class="container py-5">
      <div class="row g-4 justify-content-center">
        <div class="col-md-4">
        <!-- Asistencia -->
        <RouterLink to="/asistencia">
            <div class="card shadow border-0 rounded-4 h-100 bg-asistencia text-dark">
            <div class="card-body text-center">
              <i class="bi bi-check2-square display-4 mb-3"></i>
              <h5 class="card-title">Asistencia</h5>
              <p class="card-text">Controla y visualiza la asistencia fácilmente.</p>
            </div>
          </div>
        </RouterLink>
        </div>

        <!-- Bitácora -->
        <div class="col-md-4">
            <RouterLink to="/bitacora">
                <div class="card shadow border-0 rounded-4 h-100 bg-bitacora text-dark">
            <div class="card-body text-center">
              <i class="bi bi-journal-text display-4 mb-3"></i>
              <h5 class="card-title">Bitácora</h5>
              <p class="card-text">Registra y visualiza actividades detalladas.</p>
            </div>
          </div>
            </RouterLink>
        </div>

        <!-- Reportes -->
        <div class="col-md-4">
            <RouterLink to="/reportes">
                <div class="card shadow border-0 rounded-4 h-100 bg-reportes text-dark">
            <div class="card-body text-center">
              <i class="bi bi-bar-chart-line display-4 mb-3"></i>
              <h5 class="card-title">Reportes</h5>
              <p class="card-text">Genera reportes de uso y desempeño fácilmente.</p>
            </div>
          </div>
            </RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.bg-asistencia {
  background-color: #c4f0e1;
}

.bg-bitacora {
  background-color: #ffd6a5;
}

.bg-reportes {
  background-color: #ffb4a2;
}

.card i {
  color: #555;
}

/* Efecto de movimiento al pasar el cursor */
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}
</style>
