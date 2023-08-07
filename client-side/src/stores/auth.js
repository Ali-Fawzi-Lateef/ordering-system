import {ref} from "vue";
import {defineStore} from "pinia";
import {makeApiCall} from "@/helpers/makeApiCall";
import {setAuthToken} from "@/helpers/auth";
import router from "@/router";
import {apiErrorHandler} from "@/helpers/apiErrorHandler";

export const useAuthStore = defineStore('auth',() =>{
    const user = ref(null);
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

    return {user, login, errorMessage}
})