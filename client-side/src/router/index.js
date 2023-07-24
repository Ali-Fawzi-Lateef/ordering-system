import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import {isLoggedIn} from "@/utlis/auth";
import jwtDecode from "jwt-decode";

/*
  * The routes for the application. Each route should map to a component.
  * The "meta" property is used to set the "allowAnonymous" flag to true for the login route.
  * The "props" property is used to pass the role to the home route.
  * The "beforeEach" hook is used to redirect the user to the login page if they are not logged in.
 */
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
      name: 'home',
      component: () => import('../views/HomeView.vue'),
      props: (route) => ({role: jwtDecode(localStorage.getItem('authToken')).role})
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

/*
  * This is the "beforeEach" it is also used to redirect the user to the login page if they are not logged in and try to access a page that requires authentication
  * Also it will redirect the user to the home page if they are logged in and try to access the login page
 */
router.beforeEach((to, from, next) => {
  if (to.name === 'login' && isLoggedIn()) {
    next({ name: 'home' })
  }
  else if (!to.meta.allowAnonymous && !isLoggedIn()) {
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
