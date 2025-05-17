<script setup>
function generarPDF() {
  const element = document.getElementById('reportePDF')
  html2pdf().from(element).save('reporte.pdf')
}
</script>


<template>
    <!-- Fila superior: Búsqueda, Título, Fecha, Botón -->
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <button class="btn btn-success ms-3" @click="generarPDF">
          <i class="bi bi-file-earmark-arrow-down"></i> Generar reporte
        </button>
      </div>
</template>