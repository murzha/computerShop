<div class="cart-page">
    <?php $this->loadComponent('breadcrumbs/breadcrumbs', [
        'items' => [['title' => 'Shopping Cart']]
    ]); ?>

    <div class="container">
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-page__grid">
                <div class="cart-page__main">
                    <h1 class="cart-page__title">Shopping Cart</h1>

                    <div class="cart-list">
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                            <?php $this->loadComponent('cart/cart-item', ['item' => $item, 'id' => $id]); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="cart-page__sidebar">
                    <div class="cart-summary">
                        <h2 class="cart-summary__title">Order Summary</h2>

                        <div class="cart-summary__content">
                            <div class="cart-summary__row">
                                <span>Subtotal</span>
                                <span>$<?= number_format($_SESSION['cart.sum'], 2) ?></span>
                            </div>

                            <div class="cart-summary__row">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>

                            <div class="cart-summary__total">
                                <span>Total</span>
                                <span>$<?= number_format($_SESSION['cart.sum'], 2) ?></span>
                            </div>
                        </div>

                        <div class="cart-summary__actions">
                            <a href="/cart/checkout" class="btn btn-primary w-100">
                                Proceed to Checkout
                            </a>
                            <button class="btn btn-outline-secondary w-100 mt-2" onclick="cart.clear()">
                                Clear Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="cart-empty">
                <i class="bi bi-cart-x cart-empty__icon"></i>
                <h2 class="cart-empty__title">Your cart is empty</h2>
                <p class="cart-empty__text">Looks like you haven't added any items to your cart yet</p>
                <a href="/catalog" class="btn btn-primary">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</div>
