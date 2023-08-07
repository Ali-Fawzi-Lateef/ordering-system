<template>
  <div v-if="showLoading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="showErrorMessage" class="text-center md:m-56">
    <span class="text-error">{{showErrorMessage}}</span>
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
import {makeApiCall} from "@/helpers/makeApiCall";
import {onMounted, ref} from "vue";
import {apiErrorHandler} from "@/helpers/apiErrorHandler";

const orders = ref({})
const showLoading = ref(true);
const showErrorMessage = ref(null);
const selectedOrderStatus = ref(null);
const selectedOrderID = ref(null);

const badgeStyle = {
  'pending': 'badge-warning',
  'processing': 'badge-primary',
  'completed': 'badge-success',
  'declined': 'badge-error',
}
const buttonStyle = {
  'pending': 'btn-warning',
  'processing': 'btn-primary',
  'completed': 'btn-disabled',
  'declined': 'btn-disabled',
}
const loadingStyle = {
  'pending': 'loading loading-bars loading-xs',
  'processing': 'loading loading-dots loading-xs',
}

onMounted(() => {
  makeApiCall('order/index').then(value => {
    orders.value = value;
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })
})

const showChangeStatusModel = (status, id) => {
  const dialog = document.getElementById('change_order_status_model')
  dialog.showModal()
  selectedOrderStatus.value = status;
  selectedOrderID.value = id;
}
const updateOrderStatus = () => {
  showLoading.value = true;
  const formData = new FormData()
  formData.append('status', document.getElementById('updatedOrderStatus').value)
  formData.append('_method', 'PATCH')
  makeApiCall(`order/${selectedOrderID.value}`,formData, 'POST').then(() => {
    window.location.reload();
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
    showLoading.value = false;
  })
}
</script>