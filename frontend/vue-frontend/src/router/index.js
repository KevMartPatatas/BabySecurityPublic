import { createRouter, createWebHistory } from 'vue-router'
import {useUserStore} from "@/stores/user.js";

import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue';
import Dashboard from "@/views/Dashboard.vue";
import GestionNinos from '@/views/GestionView.vue';
import Reportes from '@/components/Reportes.vue';
import Inicio from '@/views/InicioView.vue';
import AsistenciaView from '@/views/AsistenciaView.vue';
import NotificacionesView from '@/views/NotificacionesView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: LoginView,
      meta: { hideGlobals: true, requiresAuth: true }
    },
    {
      path: '/gestion',
      name: 'Gestion',
      component: GestionNinos,
      meta: { requiresAuth: true },
    },
    {
      path: '/reporte',
      name: 'Reporte',
      component: Reportes,
      meta: { requiresAuth: true },
    },
    {
      path: '/inicio',
      name: 'Inicio',
      component: Inicio,
      meta: { requiresAuth: true },
    },
    {
      path: '/asistencia',
      name: 'Asistencia',
      component: AsistenciaView,
      meta: { requiresAuth: true },
    },
    {
      path: '/notificaciones',
      name: 'Notificaciones',
      component: NotificacionesView,
      meta: { requiresAuth: true },
    }
  ]
})


router.beforeEach((to, from, next) => {
  const userStore = useUserStore();

  if (to.name === 'Login' && !userStore.userIsLoggedIn) {
    next(); // Permite ir a Login si no está autenticado
  } else if (to.name === 'Login' && userStore.userIsLoggedIn) {
    next({ name: 'Inicio' }); // Evita que un usuario autenticado acceda al login
  } else if (!userStore.userIsLoggedIn) {
    next({ name: 'Login' }); // Redirige al login si intenta acceder a otras rutas
  } else {
    next(); // Permite la navegación
  }
});

export default router
