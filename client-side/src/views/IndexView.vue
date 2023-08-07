<template>
  <div>
    <AdminDashboard v-if="isLoggedIn() && 'admin' === getUserRole()" />
    <HomeView v-else />
  </div>
</template>

<script setup>
import AdminDashboard from '../components/AdminDashboard.vue';
import HomeView from '../components/Home.vue';
import {getUserRole, isLoggedIn} from "@/helpers/auth";
</script>
