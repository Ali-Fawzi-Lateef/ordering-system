<template>
  <NavBar />
  <div v-if="showLoading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="showErrorMessage" class="text-center md:m-56">
    <span class="text-error">{{showErrorMessage}}</span>
  </div>
  <div v-else>
    <router-link to="/add-item" class="flex justify-end">
      <button class="btn btn-ghost btn-square">
        <PlusCircleIcon class="text-success w-6" />
      </button>
    </router-link>
    <StorageTable v-bind:storage="storage.data"/>
    <Pagination v-bind:data="storage" @update="Update" class="w-full justify-center" />
  </div>

</template>

<script setup>
import NavBar from "@/components/NavBar.vue";
import Pagination from "@/components/Pagination.vue";
import StorageTable from "@/components/StorageTable.vue";
import {onMounted, ref} from "vue";
import {makeApiCall} from "@/utlis/makeApiCall";
import {PlusCircleIcon} from "@heroicons/vue/24/outline";
import {apiErrorHandler} from "@/utlis/apiErrorHandler";

const storage = ref({});
const showLoading = ref(true);
const showErrorMessage = ref(null);

onMounted(() => {
  makeApiCall('storage').then(value => {
    storage.value = value;
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })
})
const Update = (page) => {
  showLoading.value = true;
  makeApiCall('storage?page=' + page).then(value => {
    storage.value = value;
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })
}

</script>