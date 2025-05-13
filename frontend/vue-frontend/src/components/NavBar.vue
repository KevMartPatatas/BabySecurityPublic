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
          <RouterLink to="/historial" class="nav-link" active-class="active">
            <span class="d-none d-sm-inline text-white">Historial</span>
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
      <button class="btn btn-warning ms-auto rounded-circle">
        <i class="bi bi-bell-fill"></i>
      </button>
    </nav>
</template>

<style scoped>
.navbar {
    background: #12534D;
}

.nav-link {
  padding-bottom: 0.25rem; /* ajusta según necesidad */
  line-height: 1.2;
}

.nav-link.active {
  border-bottom: 5px solid #A3D9A5;
}

.nav-link.active {
  border-bottom: 5px solid #A3D9A5;
  font-weight: bold;
  /* ARREGLAR ESTO XDDDDDDD*/
}
</style>