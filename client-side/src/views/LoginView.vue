<template>
  <div class="hero h-[90vh] bg-base-200">
    <div class="hero-content w-full">
      <div class="card w-[21rem] sm:w-96 max-w-3xl shadow-2xl bg-base-100">
        <Form @submit="submit" :validation-schema="schema" v-slot="{ errors, isSubmitting }">
          <h1 class="text-5xl font-bold text-center mt-6">Login</h1>
          <div class="card-body">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <Field name="email" type="text" title="email" placeholder="email" class="input input-bordered" :class="{ 'is-invalid': errors.email }"/>
              <div class="text-xs text-error">{{ errors.email }}</div>
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Password</span>
              </label>
              <Field name="password" type="password" title="password" placeholder="password" class="input input-bordered" :class="{ 'is-invalid': errors.password }" />
              <div class="text-xs text-error">{{ errors.password }}</div>
              <label class="label">
                <router-link to="/register" class="label-text-alt link link-hover link-primary">Create an account</router-link>
              </label>
              <p class="text-xs text-error" v-if="showErrorMessage">{{showErrorMessage}}</p>
            </div>
            <div class="form-control mt-6">
              <button class="btn btn-primary" :disabled="isSubmitting">
                <span v-show="isSubmitting" class="loading loading-spinner loading-xs mr-1"></span>
                Login
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

const schema = Yup.object().shape({
  email: Yup.string()
      .required('Email is required')
      .email('Email is invalid'),
  password: Yup.string()
      .min(6, 'Password must be at least 6 characters')
      .required('Password is required'),
});
const showErrorMessage = ref(null);
const submit = async (values) => {
  const authStore = useAuthStore();
  await authStore.login(values.email, values.password);
  showErrorMessage.value = authStore.errorMessage;
}

</script>