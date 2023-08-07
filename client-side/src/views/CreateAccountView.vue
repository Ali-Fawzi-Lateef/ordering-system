<template>
  <div class="hero min-h-screen bg-base-200">
    <div class="hero-content w-full">
      <div class="card w-[21rem] sm:w-96 max-w-3xl shadow-2xl bg-base-100">
        <Form @submit="submit" :validation-schema="schema" v-slot="{ errors, isSubmitting }">
          <p class="text-4xl font-bold text-center m-6">Create Account</p>
          <div class="card-body">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Full Name</span>
              </label>
              <Field name="name" type="text" title="enter your full name" placeholder="Full Name" class="input input-bordered" :class="{ 'is-invalid': errors.name }"/>
              <div class="text-xs text-error">{{ errors.name }}</div>
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <Field name="email" type="text" title="email" placeholder="email" class="input input-bordered" :class="{ 'is-invalid': errors.email }"/>
              <div class="text-xs text-error">{{ errors.email }}</div>
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Password (6 characters minimum)</span>
              </label>
              <Field name="password" type="password" title="create a password" placeholder="password" class="input input-bordered" :class="{ 'is-invalid': errors.password }" />
              <div class="text-xs text-error">{{ errors.password }}</div>

            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Confirm Password</span>
              </label>
              <Field name="password_confirmation" type="password"  title="Reenter the password" placeholder="Confirm Password" class="input input-bordered" :class="{ 'is-invalid': errors.password_confirmation }" />
              <div class="text-xs text-error">{{ errors.password_confirmation }}</div>
            </div>
            <label class="label">
              <router-link to="/login" class="label-text-alt link link-hover link-primary">already have an account?</router-link>
            </label>
            <p class="text-sm text-error" v-if="showErrorMessage">{{showErrorMessage}}</p>
            <div class="form-control mt-6">
              <button class="btn btn-primary" :disabled="isSubmitting">
                <span v-show="isSubmitting" class="loading loading-spinner loading-xs mr-1"></span>
                Create Account
              </button>
            </div>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import { Form, Field } from 'vee-validate';
import {useAuthStore} from "@/stores/auth";
import * as Yup from 'yup';
const showErrorMessage = ref(null);

const schema = Yup.object().shape({
  name: Yup.string()
      .required('Name is required'),
  email: Yup.string()
      .required('Email is required')
      .email('Email is invalid'),
  password: Yup.string()
      .min(6, 'Password must be at least 6 characters')
      .required('Password is required'),
  password_confirmation: Yup.string()
      .oneOf([Yup.ref('password'), null], 'Passwords must match')
      .required('Confirm Password is required'),
});

const submit = async (values) => {
  const authStore = useAuthStore();
  await authStore.createAccount(values.name, values.email, values.password, values.password_confirmation);
  showErrorMessage.value = authStore.errorMessage;
}
</script>