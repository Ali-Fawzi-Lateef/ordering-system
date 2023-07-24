<template>
  <NavBar/>
    <div class="card static w-[21rem] mx-auto m-4 bg-base-100 shadow-xl">
      <div v-if="loading" class="mx-auto m-56">
        <span class="loading loading-spinner loading-lg"></span>
      </div>
      <div v-else-if="error" class="mx-auto m-56">
        <span class="text-error">Something went wrong</span>
      </div>
      <div v-else>
          <figure class="pt-10 avatar static flex-row">

            <button v-if="imageUrl" class="mt-16" @click="saveChanges" title="save">
              <CheckIcon class="text-success w-6" />
            </button>

            <div class="w-24 rounded-full" :class="imageUrl ? '' : 'ml-6'" title="profile image">
              <img v-if="imageUrl" :src="imageUrl" />
              <img v-else-if="user.profile_image" :src="user.profile_image" alt="Profile Image">
              <UserCircleIcon  />
            </div>

            <button v-if="imageUrl" @click="discardChanges" class="mt-16" title="discard">
              <XMarkIcon class="text-error w-6" />
            </button>

            <label v-else for="imageUploader" class="cursor-pointer mt-16" title="upload an image">
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

        <div class="card-body items-center text-center">
          <h2 class="card-title" title="name">{{user.name}}</h2>
          <ul class="list-none m-2 text-left">
            <li class="p-2">
              <span class="font-bold" title="email">Email:</span> {{user.email}}
            </li>
            <li class="p-2">
              <span class="font-bold" title="role">Account Type:</span> {{user.role}}
            </li>
            <li class="p-2">
              <span class="font-bold" title="date of account creation">
                Account created at:
              </span> {{to12HourFormat(user.created_at)}}
            </li>
          </ul>
        </div>
      </div>
  </div>
</template>

<script setup>
import NavBar from "@/components/NavBar.vue";
import { UserCircleIcon, ArrowUpTrayIcon, CheckIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import {ref} from "vue";
import router from "@/router";
import {apiCall} from "@/utlis/axiosServics";


const user = ref({});
const loading = ref(true);
const error = ref(false);
const imageUrl = ref(null);
const image = ref(null);

apiCall('user').then(value => {
  user.value = (value)
  loading.value = false
}).catch(err => {
  error.value = true
  loading.value = false
})
const  imagePreview = (e) => {
  image.value = e.target.files[0];
  imageUrl.value = URL.createObjectURL(image.value);
}
const discardChanges = () => {
  imageUrl.value = null;
}
const saveChanges = async () => {
  const formData = new FormData();
  formData.append('_method', 'PATCH');
  formData.append('profile_image', image.value);

  try {
    loading.value = true;
     await apiCall('user', formData, 'POST');
     router.go(0);
  } catch (e) {
    error.value = true
  }
}
const to12HourFormat = (time) => {
  const date = new Date(time);
  return date.toLocaleString('en-US', {  year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true })
}
</script>