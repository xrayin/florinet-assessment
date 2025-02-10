<script>
import { ref } from 'vue';

    // Constants
    const products = ref({
        data: [],
        links: {},
        meta: {}
    });


    // Methods
    const fetchProducts = async (page = 1) => {
        await axios.get(`/api/products?page=${page}`)
            .then(response => {
                products.value = response.data;
            })
            .catch(error => {
                console.error("Error fetching products:", error);
            });
    };

    export function useProducts() {

        return {
            products,
            fetchProducts,
        };
    }

</script>
