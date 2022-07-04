import { ref } from 'vue';
import axios from 'axios';

export default function useCategories(){
    const categories = ref([]);

    const getCategories = async () => {
        let response =  await axios.get('/api/categories')
        categories.value = response.data.map((rec)=>{
            return {
                label: rec.name,
                value: rec.id
            }
        })
    }

    return {
        categories,
        getCategories
    }
}
