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
      <div v-for="item in storage.data" class="card static bg-base-100 shadow-xl ">
        <figure class="px-10 pt-10 avatar static">
          <div class="w-20 md:w-24">
            <img class="cursor-pointer" @click="showImage(item.image)" :src="item.image" alt="Profile Image" v-if="item.image">
            <InboxStackIcon class="w-full" v-else />
          </div>
        </figure>
        <div class="card-body items-center text-center">
          <h2 class="card-title">{{ item.name }}</h2>
          <p>{{ item.description }}</p>
          <span class="text-success">{{ item.price }}$</span>
          <div class="card-actions">
            <button class="btn btn-primary">Add to cart</button>
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
import {InboxStackIcon} from "@heroicons/vue/24/outline";

const storage = ref({})
const loading = ref(true);
const error = ref(false);

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
</script>