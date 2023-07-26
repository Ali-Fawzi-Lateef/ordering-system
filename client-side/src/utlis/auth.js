import decode from 'jwt-decode'
import axios from 'axios'
import router from "@/router";

/*
    * The REST endpoint for the application.
    * The "AUTH_TOKEN_KEY" is used to store the token in local storage.
    * The "loginUser" function to log in the user.
    * The "logoutUser" function to log out the user.
    * The "setAuthToken" function is used to set the token in the axios header.
    * The "getAuthToken" function is used to get the token from local storage.
    * The "clearAuthToken" function used to clear the token from local storage.
    * The "isLoggedIn" function is used to check if the user is logged in.
    * The "getUserInfo" function  used to get the user info from the token.
    * The "getTokenExpirationDate" and "isTokenExpired" functions are used to check if the token expired.
 */
const AUTH_TOKEN_KEY = 'authToken'

export function logoutUser() {
    clearAuthToken()
    router.push('/login')
    window.location.reload()
}

export function setAuthToken(token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    localStorage.setItem(AUTH_TOKEN_KEY, token)
}

export function getAuthToken() {
    return localStorage.getItem(AUTH_TOKEN_KEY)
}

export function clearAuthToken() {
    axios.defaults.headers.common['Authorization'] = ''
    localStorage.removeItem(AUTH_TOKEN_KEY)
}

export function isLoggedIn() {
    let authToken = getAuthToken()
    return !!authToken && !isTokenExpired(authToken)
}
function getTokenExpirationDate(encodedToken) {
    let token = decode(encodedToken)
    if (!token.exp) {
        return null
    }

    let date = new Date(0)
    date.setUTCSeconds(token.exp)

    return date
}

function isTokenExpired(token) {
    let expirationDate = getTokenExpirationDate(token)
    return expirationDate < new Date()
}