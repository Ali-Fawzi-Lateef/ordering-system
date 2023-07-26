<template>
  <NavBar/>
  <div v-if="loading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="error" class="text-center m-56">
    <span class="text-error">Something went wrong</span>
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
import {apiCall} from "@/utlis/axiosServics";
import {ref} from "vue";

const orders = ref({})
const loading = ref(true);
const error = ref(false);

const badgeStyle = Object.freeze({
  'pending': 'badge-warning',
  'processing': 'badge-primary',
  'completed': 'badge-success',
  'declined': 'badge-error',
})
const loadingStyle = Object.freeze({
  'pending': 'loading loading-bars loading-xs',
  'processing': 'loading loading-dots loading-xs',
})
apiCall('order').then(value => {
  orders.value = value;
  loading.value = false;
  console.log(value)
}).catch(err => {
  error.value = true;
  loading.value = false;
  console.error(err)
})
</script>