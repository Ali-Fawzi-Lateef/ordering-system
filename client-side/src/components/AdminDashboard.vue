<template>
  <div v-if="showLoading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="showErrorMessage" class="text-center m-56">
    <span class="text-error">{{showErrorMessage}}</span>
  </div>
  <div v-else class="grid gap-4 grid-cols-1 md:grid-cols-2 m-4">
    <div class="w-[21rem] mx-auto">
      <p class="text-center text-primary">Orders</p>
      <Doughnut :data="ordersWithStatusData" />
    </div>
    <div class="w-[21rem] mx-auto">
      <p class="text-center text-primary">Top selling items</p>
      <Pie :data="topSoldItemsData" />
    </div>
  </div>
</template>

<script setup>
import {Doughnut, Pie} from 'vue-chartjs'
import {Chart as ChartJS, Tooltip, Legend, ArcElement} from 'chart.js'
import NavBar from "@/components/NavBar.vue";
import {makeApiCall} from "@/helpers/makeApiCall";
import {onMounted, ref} from "vue";
import {apiErrorHandler} from "@/helpers/apiErrorHandler";


const showLoading = ref(true)
const showErrorMessage = ref(null)
const ordersWithStatusData = ref({})
const topSoldItemsData = ref({})

ChartJS.register(ArcElement, Tooltip, ArcElement, Tooltip, Legend)

onMounted(() => {
  makeApiCall('admin/home').then(value => {
    ordersWithStatusData.value = createChartData(value.ordersWithStatus)
    topSoldItemsData.value = createChartData(value.topSoldItems)
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false
  })
})
function createChartData(items) {
  return {
    labels: items.map(item => item.status || item.name),
    datasets: [{
      data: items.map(item => item.total || parseInt(item.total_quantity)),
      backgroundColor: items.map(() => getRandomColor()),
    }]
  }
}

function getRandomColor() {
  const letters = '0123456789ABCDEF';
  let color = '#';
  for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}
</script>