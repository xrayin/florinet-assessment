<script>
import {ref, watch} from 'vue';

    // Constants
    const products = ref({
        data: [],
        links: {},
        meta: {}
    });
    const searchQuery = ref('');
    const message = ref('Loading products...');


    // Methods
    const fetchProducts = (page = 1) => {
         axios.get(`/api/products?page=${page}`, {
            params: {
                search: searchQuery.value,
                page: page
            }
        })
            .then(response => {
                products.value = response.data;
            })
            .catch(error => {
                console.error("Error fetching products:", error);
            });
    };

    const searchProducts = async () => {

        if (searchQuery.value.length === 0) {
            fetchProducts();
        };

        // Avoid unnecessary API calls
        if (searchQuery.value.length < 3) {
            message.value = 'Search parameters too short'
            return;
        };

        try {
            const response = await axios.get('/api/products', {
                params: { search: searchQuery.value }
            });

            if (response.data.data.length === 0) {
                message.value = 'No products found';
            }

            products.value = response.data;
        } catch (error) {
            console.error("Error fetching search results:", error);
        }
    };

    // Debounce API Calls
    watch(searchQuery, (newQuery) => {
        if (newQuery.length >= 3) {
            setTimeout(() => {
                searchProducts();
            }, 300); // Delay execution by 300ms
        }
    });

    export function useProducts() {

        return {
            products,
            searchQuery,
            message,
            fetchProducts,
            searchProducts,
        };
    }

</script>
