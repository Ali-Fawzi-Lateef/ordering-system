<template>
  <NavBar />
  <div v-if="showLoading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="showErrorMessage" class="text-center md:m-56">
    <span class="text-error">{{showErrorMessage}}</span>
  </div>
  <div v-else>
    <UsersTable v-bind:users="users.data"/>
    <Pagination v-bind:data="users" @update="Update" class="w-full justify-center" />
  </div>
</template>
<script setup>
import NavBar from "@/components/NavBar.vue";
import {onMounted, ref} from "vue";
import UsersTable from "@/components/UsersTable.vue";
import Pagination from "@/components/Pagination.vue";
import {makeApiCall} from "@/utlis/makeApiCall";
import {apiErrorHandler} from "@/utlis/apiErrorHandler";

const users = ref({});
const showLoading = ref(true);
const showErrorMessage = ref(false);


onMounted(() => {
  makeApiCall('users').then(value => {
    users.value = value;
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })}
)
const Update = (page) => {
  showLoading.value = true;
  makeApiCall('users?page=' + page).then(value => {
    users.value = value;
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })
}

</script>