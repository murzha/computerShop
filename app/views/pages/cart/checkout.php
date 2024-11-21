<div class="checkout-page">
    <?php $this->loadComponent('breadcrumbs/breadcrumbs', [
        'items' => [
            ['title' => 'Cart', 'url' => '/cart'],
            ['title' => 'Checkout']
        ]
    ]); ?>

    <div class="container">
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="checkout-grid">
                <div class="checkout-form">
                    <h1 class="checkout-form__title">Checkout</h1>

                    <form id="checkout-form" method="post" action="/cart/process">
                        <div class="form-section">
                            <h2 class="form-section__title">Contact Information</h2>

                            <div class="form-group">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section__title">Shipping Address</h2>

                            <div class="form-group">
                                <label class="form-label" for="address">Street Address</label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="city">City</label>
                                        <input type="text" id="city" name="city" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="postal_code">Postal Code</label>
                                        <input type="text" id="postal_code" name="postal_code" class="form-control"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section__title">Additional Information</h2>

                            <div class="form-group">
                                <label class="form-label" for="notes">Order Notes (optional)</label>
                                <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
                    </form>
                </div>

                <div class="checkout-sidebar">
                    <div class="order-summary">
                        <h2 class="order-summary__title">Order Summary</h2>

                        <div class="order-summary__list">
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <div class="order-item">
                                    <div class="order-item__image">
                                        <img src="<?= getImage($item['img']) ?>" alt="<?= h($item['title']) ?>">
                                    </div>
                                    <div class="order-item__content">
                                        <div class="order-item__title"><?= h($item['title']) ?></div>
                                        <div class="order-item__price">
                                            $<?= number_format($item['price'], 2) ?> x <?= $item['quantity'] ?>
                                        </div>
                                    </div>
                                    <div class="order-item__total">
                                        $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="order-summary__totals">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>$<?= number_format($_SESSION['cart.sum'], 2) ?></span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="summary-row summary-row--total">
                                <span>Total</span>
                                <span>$<?= number_format($_SESSION['cart.sum'], 2) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="secure-shopping">
                        <div class="secure-shopping__item">
                            <i class="bi bi-shield-check"></i>
                            <span>Secure Payment</span>
                        </div>
                        <div class="secure-shopping__item">
                            <i class="bi bi-truck"></i>
                            <span>Free Shipping</span>
                        </div>
                        <div class="secure-shopping__item">
                            <i class="bi bi-arrow-repeat"></i>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="checkout-empty">
                <i class="bi bi-cart-x checkout-empty__icon"></i>
                <h2 class="checkout-empty__title">Your cart is empty</h2>
                <p class="checkout-empty__text">Add some products to your cart before proceeding to checkout</p>
                <a href="/catalog" class="btn btn-primary">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</div>
