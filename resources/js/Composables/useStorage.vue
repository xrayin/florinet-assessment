<script>
// useStorage.js
export function useStorage() {
    const saveToStorage = (key, value, useLocalStorage = false) => {
        const storage = useLocalStorage ? localStorage : sessionStorage;
        storage.setItem(key, JSON.stringify(value));
    };

    const loadFromStorage = (key, defaultValue, useLocalStorage = false) => {
        const storage = useLocalStorage ? localStorage : sessionStorage;
        const storedValue = storage.getItem(key);
        if (storedValue) {
            return JSON.parse(storedValue);
        }
        return defaultValue;
    };

    const clearStorage = (key, useLocalStorage = false) => {
        const storage = useLocalStorage ? localStorage : sessionStorage;
        storage.removeItem(key);
    };

    return { saveToStorage, loadFromStorage, clearStorage };
}

</script>
