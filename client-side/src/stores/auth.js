import {ref} from "vue";
import {defineStore} from "pinia";
import {makeApiCall} from "@/helpers/makeApiCall";
import {setAuthToken} from "@/helpers/auth";
import router from "@/router";
import {apiErrorHandler} from "@/helpers/apiErrorHandler";

export const useAuthStore = defineStore('auth',() =>{
    const errorMessage = ref(null);
    async function login(email, password){
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        await makeApiCall('auth/login', formData, 'POST').then(value => {
            setAuthToken(value.token)
            router.push('/');
        }).catch(error => {
            errorMessage.value =  apiErrorHandler(error)
        })
    }
    async function createAccount(name, email, password, password_confirmation){
        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append( 'password', password);
        formData.append('password_confirmation', password_confirmation);

        await makeApiCall('auth/register', formData, 'POST').then(() => {
            router.push('/login');
        }).catch(error => {
            errorMessage.value = apiErrorHandler(error);
        })
    }
    return { login, createAccount, errorMessage}
})