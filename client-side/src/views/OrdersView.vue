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
        <div class="flex justify-between">
          <button :class="`btn btn-sm btn-outline ${buttonStyle[order.status]}`" @click="showChangeStatusModel(order.status, order.id)">Update state</button>

          <div :class ='`flex space-x-1 ${badgeStyle[order.status]} justify-end badge badge-sm md:badge-md badge-outline`'>
            <h2 class="text-right font-IBMPlexSansArabic-Medium">{{ order.status }}</h2>
            <span :class="`${loadingStyle[order.status]}`"/>
          </div>
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
        <div class="text-sm flex justify-between">
          <p>{{ order.user_name }}</p>
          <p class="text-right">{{ order.created_at }}</p>
        </div>
      </div>
    </div>
    <dialog id="change_order_status_model" class="modal">
      <form method="dialog" class="modal-box">
        <select id="updatedOrderStatus" class="select select-primary w-full max-w-xs">
          <option disabled selected>Update order status</option>
          <option v-if="selectedOrderStatus === 'pending' " value="processing">Accept</option>
          <option v-if="selectedOrderStatus === 'pending' " value="declined">Reject</option>
          <option v-if="selectedOrderStatus !== 'pending' " value="completed">Mark as completed</option>
        </select>
        <div class="modal-action flex justify-around">
          <button class="btn btn-primary" @click="updateOrderStatus()">set</button>
          <button class="btn">Cancel</button>
        </div>
      </form>
    </dialog>
  </div>
</template>
<script setup>

import NavBar from "@/components/NavBar.vue";
import {apiCall} from "@/utlis/axiosServics";
import {ref} from "vue";

const orders = ref({})
const loading = ref(true);
const error = ref(false);
const selectedOrderStatus = ref(null);
const selectedOrderID = ref(null);

const badgeStyle = Object.freeze({
  'pending': 'badge-warning',
  'processing': 'badge-primary',
  'completed': 'badge-success',
  'declined': 'badge-error',
})
const buttonStyle = Object.freeze({
  'pending': 'btn-warning',
  'processing': 'btn-primary',
  'completed': 'btn-disabled',
  'declined': 'btn-disabled',
})
const loadingStyle = Object.freeze({
  'pending': 'loading loading-bars loading-xs',
  'processing': 'loading loading-dots loading-xs',
})
apiCall('order/index').then(value => {
  orders.value = value;
  loading.value = false;
}).catch(err => {
  error.value = true;
  loading.value = false;
  console.error(err)
})
const showChangeStatusModel = (status, id) => {
  const dialog = document.getElementById('change_order_status_model')
  dialog.showModal()
  selectedOrderStatus.value = status;
  selectedOrderID.value = id;
}
const updateOrderStatus = () => {
  const dialog = document.getElementById('change_order_status_model')
  const formData = new FormData()
  formData.append('status', document.getElementById('updatedOrderStatus').value)
  formData.append('_method', 'PATCH')
  loading.value = true;
  apiCall(`order/${selectedOrderID.value}`,formData, 'POST').then(value => {
    window.location.reload();
    console.log(value)
  }).catch(err => {
    error.value = true;
    loading.value = false;
    console.error(err)
  })
}
</script>