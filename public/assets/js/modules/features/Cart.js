export class Cart {
    constructor(store, api, notifications) {
        this.store = store;
        this.api = api;
        this.notifications = notifications;
        this.modalElement = document.getElementById('cart-modal');

        // Bind methods
        this.handleAddToCart = this.handleAddToCart.bind(this);
        this.handleRemoveItem = this.handleRemoveItem.bind(this);
        this.handleQuantityChange = this.handleQuantityChange.bind(this);
        this.updateCartUI = this.updateCartUI.bind(this);
    }

    init() {
        // Subscribe to store changes
        this.store.on('stateChange', (event) => {
            if (event.path.startsWith('cart')) {
                this.updateCartUI();
            }
        });

        // Initialize event listeners
        this.initializeEventListeners();

        // Load initial cart state from session
        this.loadInitialState();
    }

    initializeEventListeners() {
        // Add to cart buttons
        document.addEventListener('click', (e) => {
            const addToCartBtn = e.target.closest('.add-to-cart');
            if (addToCartBtn) {
                e.preventDefault();
                const productId = addToCartBtn.dataset.id;
                const quantity = this.getQuantityInput(productId) || 1;
                this.handleAddToCart(productId, quantity);
            }
        });

        // Remove from cart buttons
        document.addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.cart-item__remove');
            if (removeBtn) {
                const productId = removeBtn.dataset.id;
                this.handleRemoveItem(productId);
            }
        });

        // Quantity controls
        document.addEventListener('click', (e) => {
            const quantityBtn = e.target.closest('.quantity-control__button');
            if (quantityBtn) {
                const input = quantityBtn.parentElement.querySelector('.quantity-control__input');
                const productId = quantityBtn.closest('[data-product-id]')?.dataset.productId;
                if (productId && input) {
                    const isIncrease = quantityBtn.textContent === '+';
                    const newValue = isIncrease ? +input.value + 1 : +input.value - 1;
                    if (newValue >= 1) {
                        this.handleQuantityChange(productId, newValue);
                    }
                }
            }
        });

        // Quantity direct input
        document.addEventListener('change', (e) => {
            if (e.target.matches('.quantity-control__input')) {
                const productId = e.target.closest('[data-product-id]')?.dataset.productId;
                if (productId) {
                    const newValue = Math.max(1, parseInt(e.target.value) || 1);
                    this.handleQuantityChange(productId, newValue);
                }
            }
        });
    }

    async loadInitialState() {
        try {
            const cartData = await this.api.getCart();
            this.store.updateCart(cartData);
        } catch (error) {
            console.error('Failed to load cart:', error);
        }
    }

    async handleAddToCart(productId, quantity) {
        try {
            this.notifications.info('Adding to cart...');
            const response = await this.api.addToCart(productId, quantity);

            if (response.success) {
                this.store.addToCart({
                    id: productId,
                    quantity: quantity,
                    ...response.product
                });
                this.notifications.success('Added to cart successfully');
                this.showCartModal();
            }
        } catch (error) {
            this.notifications.error('Failed to add to cart');
            console.error('Add to cart error:', error);
        }
    }

    async handleRemoveItem(productId) {
        try {
            this.notifications.info('Removing item...');
            const response = await this.api.removeFromCart(productId);

            if (response.success) {
                this.store.removeFromCart(productId);
                this.notifications.success('Item removed from cart');
            }
        } catch (error) {
            this.notifications.error('Failed to remove item');
            console.error('Remove from cart error:', error);
        }
    }

    async handleQuantityChange(productId, quantity) {
        try {
            const response = await this.api.updateCartQuantity(productId, quantity);

            if (response.success) {
                this.store.updateCart(response.cart);
                this.notifications.success('Cart updated');
            }
        } catch (error) {
            this.notifications.error('Failed to update quantity');
            console.error('Update quantity error:', error);
        }
    }

    updateCartUI() {
        const { items, quantity, total } = this.store.getState().cart;

        // Update cart counter
        const counter = document.querySelector('.cart-mini__count');
        if (counter) {
            counter.textContent = quantity;
        }

        // Update cart total
        const totalElement = document.querySelector('.cart-mini__total');
        if (totalElement) {
            totalElement.textContent = `$${total.toFixed(2)}`;
        }

        // Update cart modal if open
        if (this.modalElement?.classList.contains('show')) {
            this.updateCartModal();
        }
    }

    async updateCartModal() {
        try {
            const response = await this.api.getCartHtml();
            const modalBody = this.modalElement.querySelector('.modal-body');
            if (modalBody) {
                modalBody.innerHTML = response;
            }
        } catch (error) {
            console.error('Failed to update cart modal:', error);
        }
    }

    showCartModal() {
        if (this.modalElement) {
            const modalInstance = new bootstrap.Modal(this.modalElement);
            modalInstance.show();
            this.updateCartModal();
        }
    }

    getQuantityInput(productId) {
        const quantityInput = document.querySelector(`[data-product-id="${productId}"] .quantity-control__input`);
        return quantityInput ? parseInt(quantityInput.value) : null;
    }
}
