<template>
  <div>
    <AdminHomeView v-if="role === 'admin'" />
    <CustomerHomeView v-else />
  </div>
</template>

<script>
import AdminHomeView from '../components/AdminHome.vue';
import CustomerHomeView from '../components/CustomerHome.vue';

export default {
  props: ['role'],
  components: {
    AdminHomeView,
    CustomerHomeView,
  },
};
</script>
