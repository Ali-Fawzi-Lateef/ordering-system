<template>
  <nav class="navbar bg-base-200 flex justify-between">
    <div>
      <div class="drawer">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
          <div class="flex flex-row space-x-0.5">
            <label v-if="isLoggedIn()" for="my-drawer" class="drawer-button hover:cursor-pointer rounded-full mx-0.5">
              <Bars3Icon class="w-8 h-8 mt-2 text-secondary" />
            </label>
            <div class="dropdown dropdown-hover">
              <label tabindex="0"
                     class="btn btn-ghost btn-circle avatar"
                     v-on:mouseover="isDrawerOpen = true">
                <div class="rounded-full">
                  <UserCircleIcon class="h-2/3 w-2/3 mx-auto mt-2 text-secondary" />
                </div>
              </label>
              <div :class="isDrawerOpen ? '' : 'hidden' ">
                <ul v-if="isLoggedIn()" v-on:mouseleave="isDrawerOpen = false" tabindex="0" class="z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                  <li>
                    <router-link to="/profile" class="justify-between">
                      Profile
                    </router-link>
                  </li>
                  <li>
                    <button @click="logoutUser()">Logout</button>
                  </li>
                </ul>
                <ul v-else tabindex="0" v-on:mouseleave="isDrawerOpen = false" class="z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                  <li>
                    <router-link to="/login" class="justify-between">
                      Login
                    </router-link>
                  </li>
                </ul>
              </div>
            </div>
            <div class="flex-none" v-if="isLoggedIn() && 'customer' === getUserRole()">
              <div class="dropdown dropdown-hover flex">
                <label tabindex="0" v-on:mouseover="isDrawerOpen = true" class="btn btn-ghost btn-circle">
                  <div class="flex flex-col w-full h-full" >
                    <span class="badge badge-xs ml-4 badge-success badge-outline rounded-full ">{{ cart.quantity }}</span>
                    <ShoppingCartIcon class="w-6 ml-2 text-secondary" />
                  </div>
                </label>
                <div :class="isDrawerOpen ? '' : 'hidden' " tabindex="0" class="mt-12 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
                  <div v-on:mouseleave="isDrawerOpen = false" class="card-body">
                    <span class="font-bold text-lg">{{ cart.quantity }} Items</span>
                    <span class="text-success">Total: {{ cart.total }}$</span>
                    <div class="card-actions">
                      <router-link to="/cart" class="btn btn-primary btn-block">View cart</router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="drawer-side z-[1]">
          <label for="my-drawer" class="drawer-overlay"></label>
          <ul v-if="isLoggedIn() && 'customer' === getUserRole()" class="menu p-4 w-64 md:w-80 h-full bg-base-200 text-base-content">
            <li class="mt-10">
              <router-link to="/" active-class="active">
                Home
              </router-link>
            </li>
            <li>
              <router-link to="/orders-history" active-class="active">Orders</router-link>
            </li>
          </ul>
          <ul v-else class="menu p-4 w-64 md:w-80 h-full bg-base-200 text-base-content">
            <li class="mt-10">
              <router-link to="/" active-class="active">
                Home
              </router-link>
            </li>
            <li>
              <router-link to="/users" active-class="active">
                Users
              </router-link>
            </li>
            <li>
              <router-link to="/orders" active-class="active">
                Orders
              </router-link>
            </li>
            <li>
              <router-link to="/storage" active-class="active">
                Storage
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <router-link to="/" class="flex flex-row space-x-0.5">
      <span class="text-gray-600">My Tech Store</span>
      <div  class="btn btn-ghost btn-circle ">
        <img src="@/assets/logo.svg" width="32" height="32"  alt="basket icon"/>
      </div>
    </router-link>
  </nav>
</template>

<script setup>
import { UserCircleIcon, Bars3Icon, ShoppingCartIcon } from '@heroicons/vue/24/outline'
import {getUserRole, isLoggedIn, logoutUser} from "@/helpers/auth";
import {onMounted, ref} from "vue";
import {makeApiCall} from "@/helpers/makeApiCall";

const isDrawerOpen = ref(false);
const cart = ref({});

onMounted(() => {
  if (isLoggedIn() && 'customer' === getUserRole()){
    makeApiCall('cart').then(value => {
      cart.value = formattedCart(value)
    })
  }
})
const formattedCart = (value) => {
  const total = Object.values(value).reduce((accumulator, currentItem) => {
    return accumulator + currentItem.total_price_for_item;
  }, 0);
  return {
    "quantity" : Object.keys(value).length,
    "total" : total
  };
}
</script>