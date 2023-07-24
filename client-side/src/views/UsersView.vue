<template>
  <NavBar />
  <div v-if="loading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="error" class="text-center m-56">
    <span class="text-error">Something went wrong</span>
  </div>
  <div v-else>
    <UsersTable v-bind:users="users.data"/>
    <Pagination v-bind:data="users" @update="Update" class="w-full justify-center" />
  </div>
</template>
<script setup>
import NavBar from "@/components/NavBar.vue";
import {ref} from "vue";
import UsersTable from "@/components/UsersTable.vue";
import Pagination from "@/components/Pagination.vue";
import {apiCall} from "@/utlis/axiosServics";

const users = ref({});
const loading = ref(true);
const error = ref(false);

apiCall('users').then(value => {
  users.value = value;
  loading.value = false;
}).catch(err => {
  loading.value = false;
  error.value = true;
})

const Update = (page) => {
  loading.value = true;
  apiCall('users?page=' + page).then(value => {
    users.value = value;
  }).catch(err => {
    error.value = true;
  })
  loading.value = false;
}

</script>