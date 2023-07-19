<template>
  <NavBar/>
  <div class="card static sm:w-[21rem] mx-auto m-4 bg-base-100 shadow-xl">
    <div v-if="loading" class="mx-auto m-56">
      <span class="loading loading-spinner loading-lg"></span>
    </div>
    <div v-else-if="error" class="mx-auto m-56">
      <span class="text-error">Something went wrong</span>
    </div>
    <div v-else>
      <figure class="pt-10 avatar static flex-row">

        <button v-if="imageUrl" class="mt-16" @click="saveChanges" title="save">
          <CheckIcon class="text-primary w-6" />
        </button>

        <div class="w-24 rounded-full" :class="imageUrl ? '' : 'ml-6'" title="profile image">
          <img v-if="imageUrl" :src="imageUrl" />
          <img v-else-if="user.profile_image" :src="user.profile_image" alt="Profile Image">
          <UserCircleIcon v-else />
        </div>

        <button v-if="imageUrl" @click="discardChanges" class="mt-16" title="discard">
          <XMarkIcon class="text-primary w-6" />
        </button>

        <label v-else for="imageUploader" class="cursor-pointer mt-16">
          <ArrowUpTrayIcon class="text-primary w-6" />
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
import router from "@/router";
import {ArrowUpTrayIcon, CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline";
import {UserCircleIcon} from "@heroicons/vue/24/solid";

const id = router.currentRoute.value.params.id;

</script>