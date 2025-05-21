<script setup>
function mostrarReportes(){
    console.log('Esto funciona')
}


</script>


<template>
    <div class="card pastel-card border-0 shadow-sm h-100" style="background-color: #d0f4de;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-dark">Leer y Editar Reportes</h5>
              <p class="card-text text-secondary">Consulta los reportes anteriores y realiza modificaciones si es necesario.</p>
              <RouterLink to="/reportes/listado">
                <button class="btn pastel-btn" style="background-color: #95d5b2; color: white;">Ver Reportes</button>
              </RouterLink>
            </div>
          </div>
</template>

<style scoped>
.pastel-card {
  border-radius: 1rem;
  transition: transform 0.2s ease-in-out;
}
.pastel-card:hover {
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
  transform: translateY(-5px);
}
.pastel-btn {
  border-radius: 2rem;
  padding: 0.5rem 1.5rem;
  font-weight: 500;
}

</style>