<div class="cart-page">
    <div class="container">
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-page__grid">
                <div class="cart-page__main">
                    <div class="cart-list">
                        <h2 class="cart-list__title">Shopping Cart</h2>
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                            <div class="cart-list-item">
                                <div class="cart-list-item__image">
                                    <a href="/product/<?= $item['alias'] ?>">
                                        <img src="<?= getImage($item['img']) ?>" alt="<?= h($item['title']) ?>">
                                    </a>
                                </div>
                                <div class="cart-list-item__content">
                                    <h3 class="cart-list-item__title">
                                        <a href="/product/<?= $item['alias'] ?>"><?= h($item['title']) ?></a>
                                    </h3>
                                    <div class="cart-list-item__price">
                                        $<?= number_format($item['price'], 2) ?> per item
                                    </div>
                                </div>
                                <div class="cart-list-item__quantity">
                                    <div class="quantity-control quantity-control--large">
                                        <button class="quantity-control__button" onclick="cart.updateQuantity(<?= $id ?>, 'decrease')">-</button>
                                        <input type="number" class="quantity-control__input" value="<?= $item['quantity'] ?>" 
                                               min="1" max="99" onchange="cart.setQuantity(<?= $id ?>, this.value)">
                                        <button class="quantity-control__button" onclick="cart.updateQuantity(<?= $id ?>, 'increase')">+</button>
                                    </div>
                                </div>
                                <div class="cart-list-item__total">
                                    $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                </div>
                                <button class="cart-list-item__remove" onclick="cart.removeItem(<?= $id ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="cart-page__sidebar">
                    <div class="cart-checkout">
                        <h2 class="cart-checkout__title">Order Summary</h2>
                        <div class="cart-checkout__summary">
                            <div class="cart-checkout__row">
                                <span>Items:</span>
                                <span><?= $_SESSION['cart.quantity'] ?></span>
                            </div>
                            <div class="cart-checkout__row">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <div class="cart-checkout__total">
                                <span>Total:</span>
                                <span>$<?= number_format($_SESSION['cart.sum'], 2) ?></span>
                            </div>
                        </div>

                        <form id="checkout-form" class="checkout-form" method="post" action="/cart/checkout">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="order-customer-name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="order-email" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Shipping Address</label>
                                <textarea class="form-control" name="order-address" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Order Notes (optional)</label>
                                <textarea class="form-control" name="order-comment" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="cart-page__empty">
                <i class="bi bi-cart-x cart-page__empty-icon"></i>
                <h2 class="cart-page__empty-title">Your cart is empty</h2>
                <p class="cart-page__empty-text">Looks like you haven't added any items to your cart yet.</p>
                <a href="/catalog" class="btn btn-primary btn-lg">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</div>
