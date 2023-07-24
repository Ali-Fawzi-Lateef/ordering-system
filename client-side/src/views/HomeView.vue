<template>
  <div>
    <AdminHomeView v-if="role === 'admin'" />
    <CustomerHomeView v-else />
  </div>
</template>

<script>
import AdminHomeView from '../components/AdminHome.vue';
import CustomerHomeView from '../components/CustomerHome.vue';
/*
 * This is the home page of the application.
 * It will display different content based on the role of the user.
 * If the user is an admin, it will display the AdminHomeView component.
 * If the user is a customer, it will display the CustomerHomeView component.
 * The role of the user is passed in as a prop.
 * The prop is called role.
 */
export default {
  props: ['role'],
  components: {
    AdminHomeView,
    CustomerHomeView,
  },
};
</script>
