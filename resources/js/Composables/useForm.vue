<script>
import {ref, watch} from 'vue';
import { useStorage } from '../Composables/useStorage.vue';
const { saveToStorage, loadFromStorage, clearStorage } = useStorage();

const getFormInitialState = () => {
    return {
        selectedProducts: [],
        orderData: [],
    };
};

    // Constants
    const flashKey = ref('');
    const flashMessage = ref('');
    const form = ref(loadFromStorage('checkoutForm', getFormInitialState()));
    const isWatchingForm = ref(true);
    const totals = ref({
        subtotal: 0,
        shipping: 0,
        tax: 0,
        total: 0,
    });


    // Methods
    const fetchTotals = () => {
        axios.post(`/api/calculate-totals`, {selectedProducts: form.value.selectedProducts})
            .then(response => {
                if (response.data.length === 0) {
                    return;
                }
                totals.value = response.data;
            })
            .catch(error => {
                console.error("Error fetching totals:", error);
            });
    };

    // Watchers
    watch(form, (newForm) => {
        if (isWatchingForm.value) {
            saveToStorage('checkoutForm', newForm);
        }
    }, { deep: true });

    // Watch if anything changes that influences totals and get appropriate order totals from backend
    watch(() => form.value.selectedProducts, fetchTotals, { deep: true }); // Use deep: true to watch nested properties

export function useForm() {
    const addProduct = (product) => {
        const index = form.value.selectedProducts.findIndex(p => p.id === product.id);

        if (index === -1) {
            // Add the product if it's not already selected, with quantity and disassemblyEnabled
            form.value.selectedProducts.push({
                ...product,
                quantity: 1,
            });
            flashKey.value = Math.random().toString(36).substring(7);
            flashMessage.value = 'Selected product has been added to the cart.';
        } else {
            updateQuantity(product, form.value.selectedProducts[index].quantity + 1);
        }
        // If the product is already in the array, do nothing
    };

    const updateQuantity = (product, quantity) => {
        quantity = parseInt(quantity, 10);
        if (quantity < 1) {
            removeProduct(product);
            return;
        }
        // Update the selectedProducts to include quantity information
        const existingProduct = form.value.selectedProducts.find(p => p.id === product.id);
        if (existingProduct) {
            existingProduct.quantity = quantity;
        } else {
            // Add a new field for quantity in the product object
            form.value.selectedProducts.push({ ...product, quantity });
        }
        flashKey.value = Math.random().toString(36).substring(7);
        flashMessage.value = 'Selected product quantity is now: ' + quantity + '.';
    };

    const removeProduct = (product) => {
        const index = form.value.selectedProducts.findIndex(p => p.id === product.id);
        if (index !== -1) {
            form.value.selectedProducts.splice(index, 1);  // Remove if already selected
            flashKey.value = Math.random().toString(36).substring(7);
            flashMessage.value = 'Selected product has been removed from the cart.';
        }
    };

    const clearForm = () => {
        isWatchingForm.value = false;
        clearStorage('checkoutForm');
    };

    return {
        flashKey,
        flashMessage,
        form,
        totals,
        addProduct,
        removeProduct,
        updateQuantity,
        clearForm,
        fetchTotals,
    };
}
</script>
