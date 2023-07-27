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
              <p class="text-sm text-error" v-if="showErrorMessage">{{showErrorMessage}}</p>
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
import {makeApiCall} from "@/utlis/makeApiCall";
import router from "@/router";
import {apiErrorHandler} from "@/utlis/apiErrorHandler";

const email = ref(null);
const password = ref(null);
const showErrorMessage = ref(null);
const handleSubmit = async () => {
  const formData = new FormData();
  formData.append('email', email.value);
  formData.append('password', password.value);
  makeApiCall('auth/login', formData, 'POST').then(value => {
    setAuthToken(value.token)
    router.push('/');
  }).catch(error => {
    email.value = null;
    password.value = null;
    showErrorMessage.value =  apiErrorHandler(error)
  })
}

</script>