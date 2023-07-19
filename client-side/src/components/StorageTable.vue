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
        <td>{{item.name}}</td>
        <td>{{item.price}}</td>
        <td>{{item.quantity}}</td>
        <td><button
            @click="router.push(`/storage/${item.id}`)" title="show item details"
            class="btn btn-xs btn-info "
        >show</button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>

import router from "@/router";

const props = defineProps(['storage']);
// const showItem = (id) => {
//   alert(id);
// }
</script>