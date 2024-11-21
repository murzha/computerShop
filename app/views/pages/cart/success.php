<div class="order-success-page">
    <div class="container">
        <div class="order-success">
            <div class="order-success__icon">
                <i class="bi bi-check-circle"></i>
            </div>

            <h1 class="order-success__title">Thank you for your order!</h1>

            <div class="order-success__content">
                <p class="order-success__text">
                    Your order #<?= $orderId ?> has been successfully placed.<br>
                    We'll send you an email confirmation shortly with your order details.
                </p>

                <div class="order-success__details">
                    <h2>Order Details</h2>
                    <div class="order-details">
                        <div class="order-details__row">
                            <span>Order Number:</span>
                            <span>#<?= $orderId ?></span>
                        </div>
                        <div class="order-details__row">
                            <span>Order Date:</span>
                            <span><?= date('F j, Y') ?></span>
                        </div>
                        <div class="order-details__row">
                            <span>Order Status:</span>
                            <span>Processing</span>
                        </div>
                        <?php if (!empty($email)): ?>
                            <div class="order-details__row">
                                <span>Confirmation sent to:</span>
                                <span><?= h($email) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="order-success__actions">
                    <a href="/catalog" class="btn btn-primary">Continue Shopping</a>
                    <a href="/account/orders/<?= $orderId ?>" class="btn btn-outline-primary">View Order Details</a>
                </div>

                <div class="order-success__help">
                    <p>Need help? <a href="/contacts">Contact our support team</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
