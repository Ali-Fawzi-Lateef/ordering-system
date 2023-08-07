import axios from "axios";
import {getAuthToken} from "@/helpers/auth";

export function makeApiCall(endpoint, data, method = 'GET') {
    return new Promise(async (resolve, reject) => {
        try {
            let res = await axios({
                url: `${import.meta.env.VITE_API_ENDPOINT}api/v1/${endpoint}`,
                method: method,
                headers: {
                    'Authorization': `Bearer ${getAuthToken()}`
                },
                data
            })
            resolve(res.data)
        }
        catch (err) {
            console.error('Caught an error during api call:', err)
            reject(err)
        }
    })
}