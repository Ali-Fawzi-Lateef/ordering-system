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
      <div class="flex justify-end">
        <button class="btn btn-ghost btn-square" onclick="remove_item_model.showModal()">
          <TrashIcon class="text-error w-6" />
        </button>
        <dialog id="remove_item_model" class="modal">
          <form method="dialog" class="modal-box">
            <p class="py-4">Are you sure that you want to delete the item: <span class="badge badge-secondary badge-outline kbd-sm">{{name}}</span></p>
            <div class="modal-action">
              <button class="btn btn-error" @click="deleteItem">Delete</button>
              <button class="btn">Cancel</button>
            </div>
          </form>
        </dialog>
      </div>
      <figure class="sm:pt-10 pt-2 avatar static flex-row">
        <div class="w-36" title="image">
          <img v-if="imageUrl" :src="imageUrl"  alt=""/>
          <img v-else-if="image" :src="image" alt="Image" class="cursor-pointer" title="show image" @click="showImage(image)">
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
          <input type="text" title="price" placeholder="price" class="input input-bordered" v-model="price" />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Item Quantity</span>
          </label>
          <input type="text" title="quantity" placeholder="quantity" class="input input-bordered" v-model="quantity" />
        </div>
        <div class="form-control static">
          <label class="label">
            <span class="label-text">Item Description (255 characters maximum)</span>
          </label>
          <input type="text" title="description" placeholder="description" class="input input-bordered" v-model="description" />
        </div>
        <div class="form-control">
          <button type="button" class="btn btn-primary" @click="saveChanges">Save</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import NavBar from "@/components/NavBar.vue";
import router from "@/router";
import {InboxStackIcon, ArrowUpTrayIcon, XMarkIcon, TrashIcon} from "@heroicons/vue/24/outline";
import {onMounted, ref} from "vue";
import {makeApiCall} from "@/utlis/makeApiCall";
import {apiErrorHandler} from "@/utlis/apiErrorHandler";

const showLoading = ref(true);
const showErrorMessage = ref(null);
const imageUrl = ref(null);
const image = ref(null);
const imageBuffer = ref(null);
const price = ref(null);
const name = ref(null);
const quantity = ref(null);
const description = ref(null);
const id = router.currentRoute.value.params.id;

onMounted(() => {
  makeApiCall(`storage/${id}`).then(value => {
    image.value = value.image
    imageBuffer.value = value.image
    price.value = value.price
    description.value = value.description
    name.value = value.name
    quantity.value = value.quantity
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error)
  }).finally(() => {
    showLoading.value = false
  })
})
const  imagePreview = (e) => {
  image.value = e.target.files[0];
  imageUrl.value = URL.createObjectURL(image.value);
}
const discardChanges = () => {
  imageUrl.value = null;
  image.value = imageBuffer.value;
}
const showImage = (image) => {
  window.open(image, '_blank')
}
const saveChanges = async () => {
  showLoading.value = true;
  const formData = new FormData();
  formData.append('_method', 'PUT');
  formData.append('price', price.value);
  formData.append('name', name.value);
  formData.append('quantity', quantity.value);
  formData.append('description', description.value);
  imageUrl.value ? formData.append('image', image.value) : null;
  makeApiCall(`storage/${id}`, formData, 'POST').then(() => {
    router.go(-1);
  }).catch(error => {
    showErrorMessage.value = apiErrorHandler(error)
  }).finally(() => {
    showLoading.value = false
  })
}
const deleteItem = async () => {
  try {
    showLoading.value = true;
    await makeApiCall(`storage/${id}`, {}, 'DELETE');
    router.go(-1);
  } catch (e) {
    error.value = true
  }
}
</script>