<template>
  <div class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col w-full">
      <div class="card w-[21rem] md:w-full max-w-3xl shadow-2xl bg-base-100 md:flex md:flex-row">
        <form class="md:w-1/2" @submit.prevent>
          <h1 class="text-5xl font-bold text-center mt-6">Login</h1>
          <div class="card-body">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <input type="text" title="email" placeholder="email" class="input input-bordered" v-model="email" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Password</span>
              </label>
              <input type="password" title="password" placeholder="password" class="input input-bordered" v-model="password" />
              <label class="label">
                <router-link to="/register" class="label-text-alt link link-hover">Create an account</router-link>
              </label>
              <p class="text-sm text-error" v-if="showError">{{msg}}</p>
            </div>
            <div class="form-control mt-6">
              <button class="btn btn-primary" title="submit the values" @click="handleSubmit">Login</button>
            </div>
          </div>
        </form>
        <section class="hidden w-1/2 md:block bg-gray-200">
          <img alt="basket" class="mx-auto mt-32" src="@/assets/logo.svg" width="160" height="160" />
          <h2 class="text-3xl font-medium text-center m-2 mt-12">Ordering System</h2>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import {setAuthToken} from "@/utlis/auth";
import {apiCall} from "@/utlis/axiosServics";
import router from "@/router";

/*
  * This is the login page of the application.
  * It will display a form that allows the user to login.
  * The user will enter their email and password.
  * The user will click the login button to submit the form.
  * The handleSubmit function will be called when the user clicks the login button.
  * THe handleSubmit function will call the loginUser function.
  * The loginUser function will make a POST request to the /login endpoint.
 */

const email = ref('');
const password = ref('');
const showError = ref(false);
const msg = ref('');
const handleSubmit = async () => {
  const formData = new FormData();
  formData.append('email', email.value);
  formData.append('password', password.value);

  try {
    const value = await apiCall('auth/login', formData, 'POST');
    setAuthToken(value.token)
    router.push('/');
  } catch (e) {
    showError.value = true;
    if (e.request.status === 422 || e.request.status === 401) {
      msg.value = 'Invalid input';
    } else {
      msg.value = 'Something went wrong';
    }
  }
}

</script>