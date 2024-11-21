export class Api {
    constructor() {
        this.baseUrl = '';
    }

    async request(url, options = {}) {
        try {
            const response = await fetch(url, {
                ...options,
                headers: {
                    'Content-Type': 'application/json',
                    ...options.headers
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('API request failed:', error);
            throw error;
        }
    }

    // Cart APIs
    async addToCart(productId, quantity = 1) {
        return this.request(`/cart/add`, {
            method: 'POST',
            body: JSON.stringify({ id: productId, quantity })
        });
    }

    async removeFromCart(productId) {
        return this.request(`/cart/delete`, {
            method: 'POST',
            body: JSON.stringify({ id: productId })
        });
    }

    async updateCartQuantity(productId, quantity) {
        return this.request(`/cart/update`, {
            method: 'POST',
            body: JSON.stringify({ id: productId, quantity })
        });
    }

    // Catalog APIs
    async getProducts(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/catalog/products?${queryString}`);
    }

    async getProductDetails(productId) {
        return this.request(`/product/${productId}`);
    }
}
