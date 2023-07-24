<template>
  <NavBar />
  <div v-if="loading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="error" class="text-center m-56">
    <span class="text-error">Something went wrong</span>
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
import {ref} from "vue";
import {apiCall} from "@/utlis/axiosServics";
import {PlusCircleIcon} from "@heroicons/vue/24/outline";

const storage = ref({});
const loading = ref(true);
const error = ref(false);

apiCall('storage').then(value => {
  storage.value = value;
  loading.value = false;
}).catch(err => {
  loading.value = false;
  error.value = true;
  console.error(err);
})

const Update = (page) => {
  loading.value = true;
  apiCall('storage?page=' + page).then(value => {
    storage.value = value;
  }).catch(err => {
    error.value = true;
    console.error(err);
  })
  loading.value = false;
}

</script>