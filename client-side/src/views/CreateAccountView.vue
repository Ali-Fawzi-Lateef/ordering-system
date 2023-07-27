<template>
  <div class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col w-full">
      <div class="card w-[21rem] md:w-full max-w-3xl shadow-2xl bg-base-100 md:flex md:flex-row">
        <form class="md:w-1/2" @submit.prevent>
          <p class="text-4xl font-bold text-center m-6">Create Account</p>
          <div class="card-body">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Full Name</span>
              </label>
              <input type="text" title="enter your full name" placeholder="Full Name" class="input input-bordered" v-model="name" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <input type="text" title="Email" placeholder="email" class="input input-bordered" v-model="email" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Password (6 characters minimum)</span>
              </label>
              <input type="password" title="create a password" placeholder="password" class="input input-bordered" v-model="password" />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Confirm Password</span>
              </label>
              <input type="password"  title="Reenter the password" placeholder="Confirm Password" class="input input-bordered" v-model="password_confirmation" />
            </div>
            <label class="label">
              <router-link to="/login" class="label-text-alt link link-hover">already have an account?</router-link>
            </label>
            <p class="text-sm text-error" v-if="showErrorMessage">{{showErrorMessage}}</p>
            <div class="form-control mt-6">
              <button class="btn btn-primary" title="submit the values" @click="handleSubmit">Create Account</button>
            </div>
          </div>
        </form>
        <section class="hidden w-1/2 md:block bg-gray-200">
          <img alt="basket" class="mx-auto mt-32" src="@/assets/logo.svg" width="160" height="160" />
          <p class="text-3xl font-medium text-center m-2 mt-12">Ordering System</p>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import {makeApiCall} from "@/utlis/makeApiCall";
import router from "@/router";
import {apiErrorHandler} from "@/utlis/apiErrorHandler";

const name = ref(null);
const email = ref(null);
const password = ref(null);
const password_confirmation = ref(null);
const showErrorMessage = ref(null);


const handleSubmit = async () => {
  const formData = new FormData();
  formData.append('name', name.value);
  formData.append('email', email.value);
  formData.append( 'password', password.value);
  formData.append('password_confirmation', password_confirmation.value);

  makeApiCall('auth/register', formData, 'POST').then(() => {
    router.push('/login');
  }).catch(error => {
    email.value = null;
    password.value = null;
    password_confirmation.value = null;
    name.value = null;
    showErrorMessage.value = apiErrorHandler(error);
  })
}
</script>