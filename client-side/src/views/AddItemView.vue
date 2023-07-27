<template>
  <NavBar/>
  <div class="card static w-11/12 sm:w-[36rem] mx-auto m-4 bg-base-100 shadow-xl">
    <div v-if="showLoading" class="mx-auto m-56">
      <span class="loading loading-spinner loading-lg"></span>
    </div>
    <div v-else-if="showErrorMessage" class="mx-auto md:m-56">
      <span class="text-error">{{showErrorMessage}}</span>
    </div>
    <div v-else>
      <figure class="pt-10 avatar static flex-row">

        <div class="w-36" title="image">
          <img v-if="imageUrl" :src="imageUrl"  alt="stuff"/>
          <InboxStackIcon v-else />
        </div>
        <button v-if="imageUrl" @click="discardChanges" class="mt-28" title="discard">
          <XMarkIcon class="text-error w-6" />
        </button>

        <label v-else for="imageUploader" class="cursor-pointer mt-28" title="upload an image">
          <ArrowUpTrayIcon class="text-secondary w-6" />
          <input
              id="imageUploader"
              accept="image/jpeg, image/png, image/jpg, image/svg"
              type="file"
              class="hidden"
              @change="imagePreview"
          >
        </label>
      </figure>

      <form class="card-body items-center text-center">
        <div class="form-control">
          <label class="label">
            <span class="label-text">Item Name</span>
          </label>
          <input type="text" title="name" placeholder="name" class="input input-bordered" v-model="name" />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Item Price</span>
          </label>
          <input type="number" title="price" placeholder="price" class="input input-bordered" v-model="price" />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Item Quantity</span>
          </label>
          <input type="number" title="quantity" placeholder="quantity" class="input input-bordered" v-model="quantity" />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Item Description (255 characters maximum)</span>
          </label>
          <input type="text" title="description" placeholder="description" class="input input-bordered" v-model="description" />
        </div>
        <div class="form-control">
          <button type="button" class="btn btn-primary" onclick="my_modal_1.showModal()">Add</button>
          <dialog id="my_modal_1" class="modal">
            <form method="dialog" class="modal-box">
              <p class="py-4">Are you sure that you want to add this item ?</p>
              <div class="modal-action">
                <button class="btn btn-primary" @click="addItem">Add</button>
                <button class="btn">Cancel</button>
              </div>
            </form>
          </dialog>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import NavBar from "@/components/NavBar.vue";
import router from "@/router";
import {ArrowUpTrayIcon, InboxStackIcon, XMarkIcon} from "@heroicons/vue/24/outline";
import {ref} from "vue";
import {makeApiCall} from "@/utlis/makeApiCall";
import {apiErrorHandler} from "@/utlis/apiErrorHandler";

const showLoading = ref(false);
const showErrorMessage = ref(null);
const imageUrl = ref(null);
const image = ref(null);
const price = ref(null);
const name = ref(null);
const quantity = ref(null);
const description = ref(null);

const  imagePreview = (e) => {
  image.value = e.target.files[0];
  imageUrl.value = URL.createObjectURL(image.value);
}
const discardChanges = () => {
  imageUrl.value = null;
}
const addItem = async () => {
  showLoading.value = true;
  const formData = new FormData();
  formData.append('price', price.value);
  formData.append('name', name.value);
  formData.append('quantity', quantity.value);
  imageUrl.value ? formData.append('image', image.value) : null;
  formData.append('description', description.value);
  makeApiCall(`storage`, formData, 'POST').then(() =>{
    router.go(-1);
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  });
}
</script>