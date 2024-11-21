export class Forms {
    constructor(notifications) {
        this.notifications = notifications;
        this.validators = {
            email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            phone: (value) => /^\+?\d{10,}$/.test(value.replace(/\D/g, '')),
            required: (value) => value.trim().length > 0
        };
    }

    init() {
        this.initializeCheckoutForm();
        this.initializeContactForm();
        this.initializeInputMasks();
        this.initializeValidation();
    }

    initializeCheckoutForm() {
        const checkoutForm = document.getElementById('checkout-form');
        if (!checkoutForm) return;

        checkoutForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!this.validateForm(checkoutForm)) {
                this.notifications.error('Please fill in all required fields correctly');
                return;
            }

            try {
                this.notifications.info('Processing your order...');
                const formData = new FormData(checkoutForm);
                const response = await fetch('/cart/checkout', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    this.showOrderSuccess(data.orderId);
                } else {
                    throw new Error(data.message || 'Order processing failed');
                }
            } catch (error) {
                this.notifications.error('Failed to process order: ' + error.message);
            }
        });
    }

    showOrderSuccess(orderId) {
        // Clear the main content and show success message
        const mainContent = document.querySelector('.cart-page__grid');
        if (mainContent) {
            mainContent.innerHTML = `
                <div class="order-success">
                    <div class="order-success__icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h2 class="order-success__title">Thank you for your order!</h2>
                    <p class="order-success__text">
                        Your order #${orderId} has been successfully placed.
                        We'll send you an email with order details shortly.
                    </p>
                    <div class="order-success__actions">
                        <a href="/catalog" class="btn btn-primary">Continue Shopping</a>
                        <a href="/orders/${orderId}" class="btn btn-outline-primary">View Order</a>
                    </div>
                </div>
            `;
        }
    }

    initializeContactForm() {
        const contactForm = document.getElementById('contact-form');
        if (!contactForm) return;

        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!this.validateForm(contactForm)) {
                this.notifications.error('Please check your input and try again');
                return;
            }

            try {
                const formData = new FormData(contactForm);
                const response = await fetch('/contact/send', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    this.notifications.success('Message sent successfully');
                    contactForm.reset();
                } else {
                    throw new Error(data.message || 'Failed to send message');
                }
            } catch (error) {
                this.notifications.error('Failed to send message: ' + error.message);
            }
        });
    }

    initializeInputMasks() {
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = '+' + value;
                    if (value.length > 2) {
                        value = value.slice(0, 2) + ' ' + value.slice(2);
                    }
                    if (value.length > 7) {
                        value = value.slice(0, 7) + ' ' + value.slice(7);
                    }
                    if (value.length > 12) {
                        value = value.slice(0, 12) + ' ' + value.slice(12);
                    }
                }
                e.target.value = value;
            });
        });
    }

    initializeValidation() {
        const forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(form => {
            const inputs = form.querySelectorAll('[data-validate]');
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    this.validateInput(input);
                });
                input.addEventListener('blur', () => {
                    this.validateInput(input);
                });
            });
        });
    }

    validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('[data-validate]');

        inputs.forEach(input => {
            if (!this.validateInput(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateInput(input) {
        const rules = input.dataset.validate.split(',');
        const value = input.value;
        let isValid = true;

        rules.forEach(rule => {
            const validator = this.validators[rule.trim()];
            if (validator && !validator(value)) {
                isValid = false;
            }
        });

        input.classList.toggle('is-invalid', !isValid);
        input.classList.toggle('is-valid', isValid);

        const feedback = input.parentElement.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.style.display = isValid ? 'none' : 'block';
        }

        return isValid;
    }

    // Helper method to serialize form data to object
    serializeForm(form) {
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        return data;
    }
}
