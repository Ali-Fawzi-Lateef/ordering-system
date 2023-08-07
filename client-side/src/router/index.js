import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import {isLoggedIn} from "@/helpers/auth";
import jwtDecode from "jwt-decode";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: {
        allowAnonymous: true
      }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/CreateAccountView.vue'),
      meta: {
        allowAnonymous: true
      }
    },
    {
      path: '/',
      name: 'index',
      component: () => import('../views/IndexView.vue'),
      meta: {
        allowAnonymous: true
      }
    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import('../views/ProfileView.vue')
    },
    {
      path: '/storage',
      name: 'storage',
      component: () => import('../views/StorageView.vue')
    },
    {
      path: '/orders',
      name: 'orders',
      component: () => import('../views/OrdersView.vue')
    },
    {
      path: '/users',
      name: 'users',
      component: () => import('../views/UsersView.vue')
    },
    {
      path: '/orders-history',
      name: 'orders-history',
      component: () => import('../views/OrdersHistoryView.vue')
    },
    {
      path: '/storage/:id',
      name: 'item-details',
      component: () => import('../views/ItemView.vue'),
    },
    {
      path: '/add-item',
      name: 'add-item',
      component: () => import('../views/AddItemView.vue'),
    },
    {
      path: '/cart',
      name: 'cart',
      component: () => import('../views/CartView.vue'),
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (!to.meta.allowAnonymous && !isLoggedIn()) {
    next({
      path: '/login',
      query: { redirect: to.fullPath }
    })
  }
  else {
    next()
  }
});

export default router
