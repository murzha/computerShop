import {EventEmitter} from "./EventEmitter";

export class Store extends EventEmitter {
    constructor() {
        super();
        this.state = {
            cart: {
                items: [],
                total: 0,
                quantity: 0
            },
            catalog: {
                filters: {
                    brand: null,
                    priceRange: {
                        min: null,
                        max: null
                    },
                    sort: 'default'
                },
                view: 'grid' // grid or list
            }
        };
    }

    getState() {
        return this.state;
    }

    setState(path, value) {
        // Split path into array (e.g., 'cart.items' -> ['cart', 'items'])
        const pathArray = path.split('.');
        let current = this.state;

        // Traverse the path until we reach the last element
        for (let i = 0; i < pathArray.length - 1; i++) {
            current = current[pathArray[i]];
        }

        // Set the value and emit change event
        const lastKey = pathArray[pathArray.length - 1];
        current[lastKey] = value;

        this.emit('stateChange', {
            path,
            value,
            state: this.state
        });
    }

    // Cart specific methods
    updateCart(cartData) {
        this.setState('cart', {
            ...this.state.cart,
            ...cartData
        });
    }

    addToCart(item) {
        const items = [...this.state.cart.items];
        const existingItem = items.find(i => i.id === item.id);

        if (existingItem) {
            existingItem.quantity += item.quantity;
        } else {
            items.push(item);
        }

        this.updateCart({
            items,
            quantity: this.calculateTotalQuantity(items),
            total: this.calculateTotalPrice(items)
        });
    }

    removeFromCart(itemId) {
        const items = this.state.cart.items.filter(item => item.id !== itemId);

        this.updateCart({
            items,
            quantity: this.calculateTotalQuantity(items),
            total: this.calculateTotalPrice(items)
        });
    }

    // Helper methods for cart calculations
    calculateTotalQuantity(items) {
        return items.reduce((total, item) => total + item.quantity, 0);
    }

    calculateTotalPrice(items) {
        return items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    // Catalog specific methods
    updateFilters(filters) {
        this.setState('catalog.filters', {
            ...this.state.catalog.filters,
            ...filters
        });
    }

    setView(view) {
        this.setState('catalog.view', view);
    }
}
