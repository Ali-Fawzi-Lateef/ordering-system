<template>
  <div class="overflow-x-auto">
    <table class="table table-sm md:table-md lg:table-lg static">
      <thead>
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in storage">
        <td class="flex flex-row space-x-2">
          <div>
            <figure class="avatar static">
              <div class="w-6 md:w-8 xl:w-10">
                <img :src="item.image" alt="Profile Image" v-if="item.image">
                <UserCircleIcon v-else />
              </div>
            </figure>
          </div>
          <span>{{item.name}}</span>
        </td>
        <td>{{ item.price }}$</td>
        <td>{{ item.quantity }}</td>
        <td><button
            @click="router.push(`/storage/${item.id}`)" title="show item details"
            class="btn btn-xs btn-outline btn-info "
        >show</button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>

import router from "@/router";
import {UserCircleIcon} from "@heroicons/vue/24/outline";

const props = defineProps(['storage']);
</script>