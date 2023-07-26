<template>
  <NavBar/>
  <div v-if="loading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="error" class="text-center m-56">
    <span class="text-error">Something went wrong</span>
  </div>
  <div v-else>
    <div class="grid grid-cols-2 m-2 sm:grid-cols-3 sm:m-3 lg:grid-cols-4 lg:m-4 gap-4 ">
      <div v-for="item in storage.data" class="card static bg-base-100 shadow-xl flex">
        <div class="badge badge-success badge-sm badge-outline">{{ item.quantity }} Available</div>
        <figure class="px-10 pt-10 avatar static">
          <div class="w-20 md:w-24">
            <img class="cursor-pointer" @click="showImage(item.image)" :src="item.image" alt="Item Image" v-if="item.image">
            <InboxStackIcon class="w-full" v-else />
          </div>
        </figure>
        <div class="card-body items-center text-center">
          <h2 class="card-title">{{ item.name }}</h2>
          <h6 class="text-xs sm:text-sm md:text-md grow">{{ item.description }}</h6>
          <span class="text-success">{{ item.price }}$</span>
          <div class="card-actions">
            <div v-if="selectedItemID === item.id" class="flex justify-center">
              <button class="btn btn-ghost btn-square" @click="updateCart(item.id, 1)">
                <PlusCircleIcon class="text-success w-6" />
              </button>
              <span class="badge badge-primary badge-outline kbd-sm">{{ counter }}</span>
              <button class="btn btn-ghost btn-square" @click="updateCart(item.id, -1)">
                <MinusCircleIcon class="text-error w-6" />
              </button>
            </div>
            <button v-else class="btn btn-primary" @click="addToCart(item.id)">Add to cart</button>
          </div>
        </div>
      </div>
    </div>
    <Pagination v-bind:data="storage" @update="Update" class="w-full justify-center" />
  </div>

</template>

<script setup>
import NavBar from "@/components/NavBar.vue";
import {apiCall} from "@/utlis/axiosServics";
import {ref} from "vue";
import Pagination from "@/components/Pagination.vue";
import {InboxStackIcon, PlusCircleIcon, MinusCircleIcon} from "@heroicons/vue/24/outline";

const storage = ref({})
const loading = ref(true);
const error = ref(false);
const counter = ref(0);
const selectedItemID = ref(null);

apiCall('storage').then(value => {
  storage.value = value;
  loading.value = false;
}).catch(err => {
  loading.value = false;
  console.error(err)
})
const Update = (page) => {
  loading.value = true;
  apiCall('storage?page=' + page).then(value => {
    storage.value = value;
    window.scrollTo(0,0);
  }).catch(err => {
    error.value = true;
    console.error(err);
  })
  loading.value = false;
}
const showImage = (image) => {
  window.open(image, '_blank');
}
const addToCart = (id) => {
  const formData = new FormData();
  formData.append('storage_id', id);
  apiCall(`cart`, formData,'POST').then(value => {
    selectedItemID.value = id;
    counter.value = value.quantity;
  }).catch(err => {
    console.error(err);
  })
}
const updateCart = (id, value) =>{
  const formData = new FormData();
  formData.append('quantity', value);
  formData.append('_method', 'PATCH');
  apiCall(`cart/${id}`, formData, 'POST').then(value => {
    counter.value = value.quantity;
  }).catch(err => {
    console.error(err);
  })
}
</script>