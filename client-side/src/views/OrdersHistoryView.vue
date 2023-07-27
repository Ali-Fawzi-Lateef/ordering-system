<template>
  <NavBar/>
  <div v-if="showLoading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="showErrorMessage" class="text-center md:m-56">
    <span class="text-error">{{showErrorMessage}}</span>
  </div>
    <div v-else class="grid grid-cols-1 gap-4 lg:m-6">
      <div v-for="order in orders" class="card static mx-auto w-80 sm:w-[24rem] md:w-full flex flex-row bg-base-100 shadow-xl">
        <div class="card-body">
          <div :class ='`flex ml-auto space-x-1 ${badgeStyle[order.status]} justify-end badge badge-sm md:badge-md badge-outline`'>
            <h2 class="text-right font-IBMPlexSansArabic-Medium">{{ order.status }}</h2>
            <span :class="`${loadingStyle[order.status]}`"/>
          </div>
          <div class="overflow-x-auto">
            <table class="table static">
              <thead>
              <tr>
                <th>Item Name</th>
                <th>Quantity</th>
              </tr>
              </thead>
              <tbody >
              <tr v-for="item in order.item">
                <td>{{ item.name }}</td>
                <td>{{ item.quantity }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <p class="flex ml-auto text-sm">{{ order.created_at }}</p>
        </div>
      </div>
  </div>
</template>
<script setup>

import NavBar from "@/components/NavBar.vue";
import {makeApiCall} from "@/utlis/makeApiCall";
import {onMounted, ref} from "vue";
import {apiErrorHandler} from "@/utlis/apiErrorHandler";

const orders = ref({})
const showLoading = ref(true);
const showErrorMessage = ref(null);

const badgeStyle = {
  'pending': 'badge-warning',
  'processing': 'badge-primary',
  'completed': 'badge-success',
  'declined': 'badge-error',
}
const loadingStyle ={
  'pending': 'loading loading-bars loading-xs',
  'processing': 'loading loading-dots loading-xs',
}
onMounted(() => {
  makeApiCall('order').then(value => {
    orders.value = value;
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })
})
</script>