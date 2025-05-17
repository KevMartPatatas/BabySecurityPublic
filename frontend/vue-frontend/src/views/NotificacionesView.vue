<script setup>
import NavBar from '@/components/NavBar.vue';
</script>

<template>
  <div class="container-fluid bg-light min-vh-100 p-0">
    <NavBar />

    <div class="container py-5">
      <!-- Notificaciones importantes -->
      <section class="mb-5">
        <h4 class="mb-4">Notificaciones Importantes</h4>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card card-important shadow-sm rounded-4 p-4 h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="badge-important me-3">
                  <i class="fas fa-exclamation"></i>
                </div>
                <h5 class="mb-0 fw-semibold">Recordatorio: Hacer bitácoras de DLA</h5>
              </div>
              <p class="mb-2 text-muted">Fecha límite: 18 de mayo, 2025</p>
              <p class="text-important mb-0">Es importante registrar las actividades del día para mantener el control.</p>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-important shadow-sm rounded-4 p-4 h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="badge-important me-3">
                  <i class="fas fa-exclamation"></i>
                </div>
                <h5 class="mb-0 fw-semibold">Revisión de reportes semanales</h5>
              </div>
              <p class="mb-2 text-muted">Fecha límite: 20 de mayo, 2025</p>
              <p class="text-important mb-0">No olvides revisar y validar los reportes de la semana.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Notificaciones generales -->
      <section>
        <h4 class="mb-4">Notificaciones Generales</h4>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card card-general shadow-sm rounded-4 p-4 h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="badge-general me-3">
                  <i class="fas fa-birthday-cake"></i>
                </div>
                <h5 class="mb-0 fw-semibold">Cumpleaños de Juan Pérez</h5>
              </div>
              <p class="mb-2 text-muted">Falta 1 día</p>
              <p class="text-general mb-0">No olvides felicitar a Juan mañana.</p>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-general shadow-sm rounded-4 p-4 h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="badge-general me-3">
                  <i class="fas fa-calendar-alt"></i>
                </div>
                <h5 class="mb-0 fw-semibold">Evento: Feria Escolar</h5>
              </div>
              <p class="mb-2 text-muted">Fecha: 25 de mayo, 2025</p>
              <p class="text-general mb-0">Participa en la feria para conocer nuevas actividades.</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<style scoped>
h2 {
  font-weight: 700;
  color: #a3cef1; /* azul pastel suave */
}

h4 {
  font-weight: 600;
  color: #6a8caf; /* azul grisáceo pastel */
}

.card {
  background-color: #ffffff;
  border: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 20px rgba(163, 206, 241, 0.3);
}

.card-important {
  border-left: 6px solid #f7a1a1; /* rosa pastel */
}

.card-general {
  border-left: 6px solid #a1d8b4; /* verde pastel */
}

.badge-important, .badge-general {
  font-size: 1.6rem;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  user-select: none;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.badge-important {
  background-color: #f7a1a1;
}

.badge-general {
  background-color: #a1d8b4;
}

.text-important {
  color: #f7a1a1;
  font-weight: 600;
}

.text-general {
  color: #a1d8b4;
  font-weight: 600;
}
</style>
