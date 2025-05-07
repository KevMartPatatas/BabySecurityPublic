import { createRouter, createWebHistory } from 'vue-router'
import {useUserStore} from "@/stores/user.js";

import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue';
import Dashboard from "@/views/Dashboard.vue";
import GestionNinos from '@/views/GestionNinos.vue';
import Reportes from '@/components/Reportes.vue';
import Inicio from '@/views/inicio.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/gestion',
      name: 'gestion',
      component: GestionNinos
    },
    {
      path: '/reporte',
      name: 'reporte',
      component: Reportes
    }
    ,
    {
      path: '/inicio',
      name: 'inicio',
      component: Inicio
    }
  ]
})
export default router
