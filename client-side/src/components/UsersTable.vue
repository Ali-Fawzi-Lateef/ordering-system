<template>
  <div class="overflow-x-auto">
    <table class="table table-sm md:table-md lg:table-lg static">
      <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role Color</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="user in users">
        <td class="flex flex-row space-x-2">
          <div>
            <figure class="avatar static">
              <div class="w-6 md:w-8 xl:w-10 rounded-xl">
                <img :src="user.profile_image" alt="Profile Image" v-if="user.profile_image">
                <UserCircleIcon v-else />
              </div>
            </figure>
          </div>
          <span>{{user.name}}</span>
        </td>
        <td>{{ user.email}}</td>
        <td>{{user.role}}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import {UserCircleIcon} from "@heroicons/vue/24/outline";

const props = defineProps(['users']);
</script>