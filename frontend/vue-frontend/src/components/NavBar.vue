<script setup>
  import LogoutButton from './LogoutButton.vue';
</script>

<template>
    <nav class="navbar px-4">
      <div class="navbar-brand d-flex align-items-center gap-3">
        <img src="@/assets/logo.png" width="50px">
      </div>
      <ul class="navbar-nav flex-row gap-5 ms-5">
        <li class="nav-item">
          <RouterLink to="/inicio" class="nav-link" active-class="active">
            <span class="d-none d-sm-inline text-white">Inicio</span>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink to="/gestion" class="nav-link" active-class="active">
            <span class="d-none d-sm-inline text-white">Gestión de niños</span>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink to="/asistencia" class="nav-link" active-class="active">
            <span class="d-none d-sm-inline text-white">Asistencia</span>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink to="/bitacora" class="nav-link" active-class="active">
            <span class="d-none d-sm-inline text-white">Bitacora</span>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink to="/personal" class="nav-link" active-class="active">
            <span class="d-none d-sm-inline text-white">Personal</span>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink to="/reportes" class="nav-link" active-class="active">
            <span class="d-none d-sm-inline text-white">Reportes</span>
          </RouterLink>
        </li>
      </ul>
      <LogoutButton />
      <RouterLink to="/notificaciones">
  <button class="btn btn-notification rounded-circle d-flex align-items-center justify-content-center">
    <i class="bi bi-bell-fill"></i>
  </button>
</RouterLink>
    </nav>
</template>

<style scoped>
.navbar {
    background: #12534D;
}

.nav-link {
  padding-bottom: 0.25rem;
  line-height: 1.2;
  display: inline-block;
}

.nav-link.active {
  border-bottom: 5px solid #A3D9A5;
  font-weight: bold;
}

.btn-notification {
  width: 48px;
  height: 48px;
  background-color: white;
  color: #7fb3d5; /* azul pastel */
  border: none;
  box-shadow: 0 2px 8px rgba(127, 179, 213, 0.3);
  transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
}

.btn-notification i {
  font-size: 1.5rem;
}

.btn-notification:hover {
  background-color: #7fb3d5; /* azul pastel */
  color: white;
  box-shadow: 0 4px 12px rgba(127, 179, 213, 0.6);
  cursor: pointer;
}

</style>