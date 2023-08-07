<template>
  <div v-if="showLoading" class="mx-auto m-56 flex justify-center">
    <span class="loading loading-spinner loading-lg"></span>
  </div>
  <div v-else-if="showErrorMessage" class="text-center md:m-56">
    <span class="text-error">{{showErrorMessage}}</span>
  </div>
  <div v-else>
    <div class="flex justify-between">
      <button class="btn btn-ghost btn-square" onclick="clear_cart_model.showModal()">
        <TrashIcon class="text-error w-6" />
      </button>
      <dialog id="clear_cart_model" class="modal">
        <form method="dialog" class="modal-box">
          <p class="py-4">Are you sure that you want to clear your cart?</p>
          <div class="modal-action">
            <button class="btn btn-error" @click="clearCart()">Delete</button>
            <button class="btn">Cancel</button>
          </div>
        </form>
      </dialog>

      <button class="btn btn-ghost btn-square" onclick="submit_order_model.showModal()">
        <ArrowRightIcon class="text-primary w-6" />
      </button>
      <dialog id="submit_order_model" class="modal">
        <form method="dialog" class="modal-box">
          <p class="py-4">Are you sure that you want to submit your order?</p>
          <div class="modal-action">
            <button class="btn btn-primary" @click="submitOrder()">Order Now</button>
            <button class="btn">Cancel</button>
          </div>
        </form>
      </dialog>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 lg:m-6">
      <div v-for="item in cart" class="card static mx-auto w-80 sm:w-[24rem] md:w-full flex flex-row bg-base-100 shadow-xl">
        <figure class="m-6 avatar static">
          <div class="w-20 md:w-24">
            <img class="cursor-pointer" @click="showImage(item.image)" :src="item.image" alt="item Image" v-if="item.image">
            <InboxStackIcon class="w-full" v-else />
          </div>
        </figure>
        <div class="card-body items-center text-center ">
          <h2 class="text-center font-IBMPlexSansArabic-Medium">{{ item.name }}</h2>
          <h4 class="text-xs sm:text-sm md:text-md">Quantity: <span class="badge badge-outline badge-xs badge-primary">{{ item.quantity }}</span></h4>
          <h6 class="text-xs sm:text-sm md:text-md">Price: <span class="text-success">{{ item.total_price_for_item }}$</span></h6>
          <div class="card-actions">
            <button class="btn btn-ghost btn-square" @click="removeFromCart(item.id)">
              <MinusIcon class="text-error w-6" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>

import NavBar from "@/components/NavBar.vue";
import {makeApiCall} from "@/helpers/makeApiCall";
import {InboxStackIcon, TrashIcon, ArrowRightIcon, MinusIcon} from "@heroicons/vue/24/outline";
import {onMounted, ref} from "vue";
import {apiErrorHandler} from "@/helpers/apiErrorHandler";
import router from "@/router";

const cart = ref({})
const showLoading = ref(true);
const showErrorMessage = ref(null);
onMounted(() => {
  makeApiCall('cart/content').then(value => {
    cart.value = value;
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })
})
const showImage = (image) => {
  window.open(image, '_blank');
}
const removeFromCart = (id) => {
  showLoading.value = true;
  makeApiCall(`cart/${id}`, '','DELETE').then(() => {
    window.location.reload();
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })
}
const clearCart = () => {
  showLoading.value = true;
  makeApiCall('cart/clear', '','DELETE').then(() => {
    router.push('/');
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  })
}
const submitOrder = () => {
  showLoading.value = true;
  makeApiCall('order', '', 'POST').then(() => {
    router.push('/');
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error);
  }).finally(() => {
    showLoading.value = false;
  });
}
</script>