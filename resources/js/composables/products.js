import { ref } from 'vue';
import axios from 'axios';

export default function useProducts(){
    const products = ref([]);

    const getProducts = async (parameters) => {
        let endpoint = '/api/products?'
        let paramCount = Object.keys(parameters).length
        Object.keys(parameters).forEach( (key,i) => {
            if(!!parameters[key]){
                endpoint += `${key}=${parameters[key]}`
                if(paramCount < i){
                    endpoint += '&'
                }
            }
        })

        let response =  await axios.get(endpoint)
        products.value = response.data
    }

    const destroyProduct = async (id) => {
        await axios.delete(`/api/products/${id}`)
    }

    const addOrUpdateProduct = async (product) => {
        await axios.post('/api/products', product)
    }

    return {
        products,
        getProducts,
        destroyProduct,
        addOrUpdateProduct
    }
}
