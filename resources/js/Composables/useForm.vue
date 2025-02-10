<script>
import { ref, watch } from 'vue';
import { useStorage } from '../Composables/useStorage.vue';
import { usePage } from "@inertiajs/vue3";
const { saveToStorage, loadFromStorage, clearStorage } = useStorage();

// Global state
const getInitialPlaceState = () => {
    return {
        name: '',
        formatted_address: '',
    };
};
const getFormInitialState = () => {
    return {
        order_number: null,
        identifier_code: null,
        order_code: null,
        date: [],
        selectedItems: [],
        email: null,
        firstname: null,
        lastname: null,
        telephone_number: null,
        address: {
            getInitialPlaceState
        },
        postal_code: null,
        house_number: null,
        city: null,
        province: null,
        country: null,
        floor: "ground",
        elevator: false,
        address_billing: {
            getInitialPlaceState
        },
        postal_code_billing: null,
        house_number_billing: null,
        city_billing: null,
        province_billing: null,
        country_billing: null,
        comment: null,
        paymentMethod: null,
        startingRate: 45,
        totalPriceOfDisassembly: 0,
        totalPriceOfItems: 0,
        total: 0,
        discountPercentage: 0,
        totalDiscount: 0,
        totalPriceOfItemsAfterDiscount: 0,
        totalTax: 0,
        totalWithoutTax: 0,
        totalQuantity: 0,
        tax: 0,
        totalPriceInCents: 0,
        acceptTermsAndConditions: false,
        processingForm: false,
    };
};


// Constants
const form = ref(loadFromStorage('checkoutForm', getFormInitialState()));
const items = ref([]);
const isWatchingForm = ref(true);
const pageProps = usePage().props;


// Methods
const fetchItems = async (locale) => {
    try {
        const response = await axios.get('/api/items', {
            headers: {
                'Accept-Language': locale,
            },
        });
        items.value = response.data.itemsWithCategories;
    } catch (error) {
        console.error('There was an error fetching the items: ', error);
    }
};

const calculateOrderTotals = async () => {
    try {
        const response = await axios.post('/api/checkout/calculate/order', {
            selectedItems: form.value.selectedItems,
        });
        form.value.startingRate = response.data.startingRate;
        form.value.totalPriceOfDisassembly = response.data.totalPriceOfDisassembly;
        form.value.totalPriceOfItems = response.data.totalPriceOfItems;
        form.value.total = response.data.total;
        form.value.discountPercentage = response.data.discountPercentage;
        form.value.totalDiscount = response.data.totalDiscount;
        form.value.totalPriceOfItemsAfterDiscount = response.data.totalPriceOfItemsAfterDiscount;
        form.value.totalTax = response.data.totalTax;
        form.value.totalWithoutTax = response.data.totalWithoutTax;
        form.value.totalQuantity = response.data.totalQuantity;
        form.value.tax = response.data.tax;
        form.value.totalPriceInCents = response.data.totalPriceInCents;
    } catch (error) {
        // Handle error (e.g., show an error message to the user)
        pageProps.errors = {"Error calculating order total: ": error};

        // nextTick(() => {
        //     scrollToOrderSummaryErrors(); // Ensure this function exists or handle the error appropriately
        // });
    }
}

// Watchers
// Watch for changes in form data
watch(form, (newForm) => {
    if (isWatchingForm.value) {
        saveToStorage('checkoutForm', newForm);
    }
}, { deep: true });

// Watch if anything changes that influences totals and get appropriate order totals from backend
watch(() => form.value.selectedItems, calculateOrderTotals, { deep: true }); // Use deep: true to watch nested properties

export function useForm() {
    const addItem = (item) => {
        const index = form.value.selectedItems.findIndex(p => p.id === item.id);

        if (index === -1) {
            // Add the item if it's not already selected, with quantity and disassemblyEnabled
            form.value.selectedItems.push({
                ...item,
                quantity: 1,
                disassemblyEnabled: false // or 0
            });
        } else {
            updateQuantity(item, form.value.selectedItems[index].quantity + 1);
        }
        // If the item is already in the array, do nothing
    };

    const removeItem = (item) => {
        const index = form.value.selectedItems.findIndex(p => p.id === item.id);
        if (index !== -1) {
            form.value.selectedItems.splice(index, 1);  // Remove if already selected
        }
    };

    const updateQuantity = (item, quantity) => {
        quantity = parseInt(quantity, 10);
        if (quantity < 1) {
            removeItem(item);
            return;
        }
        // Update the selectedItems to include quantity information
        const existingItem = form.value.selectedItems.find(p => p.id === item.id);
        if (existingItem) {
            existingItem.quantity = quantity;
        } else {
            // Add a new field for quantity in the item object
            form.value.selectedItems.push({ ...item, quantity });
        }
    };

    const updateDisassemblyEnabled = (item, disassemblyEnabled) => {
        // Update the selectedItems to include quantity information
        disassemblyEnabled = !disassemblyEnabled;
        const existingItem = form.value.selectedItems.find(p => p.id === item.id);
        if (existingItem) {
            existingItem.disassemblyEnabled = disassemblyEnabled;
        } else {
            // Add a new field for quantity in the item object
            form.value.selectedItems.push({ ...item, disassemblyEnabled });
        }
    };

    const clearForm = () => {
        isWatchingForm.value = false;
        clearStorage('checkoutForm');
    };

    return {
        form,
        items,
        fetchItems,
        calculateOrderTotals,
        addItem,
        removeItem,
        updateQuantity,
        updateDisassemblyEnabled,
        getInitialPlaceState,
        clearForm,
    };
}
</script>
