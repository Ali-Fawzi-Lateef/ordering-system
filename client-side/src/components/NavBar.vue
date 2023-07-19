<template>
  <nav class="navbar bg-base-200 flex justify-between">
    <div>
      <div class="drawer">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
          <!-- Page content here -->
          <div class="flex flex-row space-x-0.5">
            <label for="my-drawer" class="drawer-button hover:cursor-pointer rounded-full mx-0.5">
              <Bars3Icon class="w-8 h-8 mt-2 text-gray-600" />
            </label>
            <div class="dropdown dropdown-hover ">
              <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                <div class="rounded-full">
                  <Cog6ToothIcon class="h-2/3 w-2/3 mx-auto mt-2 text-gray-600" />
                </div>
              </label>
              <ul tabindex="0" class=" z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                <li>
                  <router-link to="/profile" class="justify-between">
                    Profile
                  </router-link>
                </li>
                <li>
                  <button @click="logoutUser()">Logout</button>
                </li>
              </ul>
            </div>
            <div class="flex-none" v-if="isCustomer()">
              <div class="dropdown dropdown-hover">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                  <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span class="badge badge-sm indicator-item">8</span>
                  </div>
                </label>
                <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
                  <div class="card-body">
                    <span class="font-bold text-lg">8 Items</span>
                    <span class="text-info">Subtotal: $999</span>
                    <div class="card-actions">
                      <button class="btn btn-primary btn-block">View cart</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="drawer-side">
          <label for="my-drawer" class="drawer-overlay"></label>
          <ul v-if="isCustomer()" class="menu p-4 w-64 md:w-80 h-full bg-base-200 text-base-content">
            <li class="mt-10">
              <router-link to="/orders-history" active-class="active">Orders</router-link>
            </li>
          </ul>

          <ul v-else class="menu p-4 w-64 md:w-80 h-full bg-base-200 text-base-content">
            <li class="mt-10">
              <router-link to="/orders" active-class="active">
                Orders
              </router-link>
            </li>
            <li>
              <router-link to="/storage" active-class="active">
                Storage
              </router-link>
            </li>
            <li>
              <router-link to="/users" active-class="active">
                Users
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <router-link to="/" class="flex flex-row space-x-0.5">
      <span class="text-gray-600">Ordering System</span>
      <div  class="btn btn-ghost btn-circle ">
        <img src="@/assets/logo.svg" width="32" height="32"  alt="basket icon"/>
      </div>
    </router-link>
  </nav>
</template>

<script setup>
import { Cog6ToothIcon, Bars3Icon } from '@heroicons/vue/24/solid'
import { logoutUser } from "@/utlis/auth";
import jwtDecode from "jwt-decode";

const isCustomer = () =>{
  return jwtDecode(localStorage.getItem('authToken')).role === 'customer';
}
</script>