<div class="cart-modal">
    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cart-modal__list">
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <div class="cart-item">
                    <div class="cart-item__image">
                        <a href="/product/<?= $item['alias'] ?>">
                            <img src="<?= getImage($item['img']) ?>" alt="<?= h($item['title']) ?>">
                        </a>
                    </div>
                    <div class="cart-item__content">
                        <div class="cart-item__title">
                            <a href="/product/<?= $item['alias'] ?>"><?= h($item['title']) ?></a>
                        </div>
                        <div class="cart-item__price">
                            $<?= number_format($item['price'], 2) ?>
                        </div>
                    </div>
                    <div class="cart-item__quantity">
                        <div class="quantity-control">
                            <button class="quantity-control__button" onclick="cart.updateQuantity(<?= $id ?>, 'decrease')">-</button>
                            <input type="number" class="quantity-control__input" value="<?= $item['quantity'] ?>" 
                                   min="1" max="99" onchange="cart.setQuantity(<?= $id ?>, this.value)">
                            <button class="quantity-control__button" onclick="cart.updateQuantity(<?= $id ?>, 'increase')">+</button>
                        </div>
                    </div>
                    <div class="cart-item__total">
                        $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                    </div>
                    <button class="cart-item__remove" onclick="cart.removeItem(<?= $id ?>)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-modal__summary">
            <div class="cart-summary">
                <div class="cart-summary__row">
                    <span>Items:</span>
                    <span><?= $_SESSION['cart.quantity'] ?></span>
                </div>
                <div class="cart-summary__row">
                    <span>Total:</span>
                    <span class="cart-summary__total">$<?= number_format($_SESSION['cart.sum'], 2) ?></span>
                </div>
            </div>
        </div>

        <div class="cart-modal__actions">
            <a href="/cart" class="btn btn-primary">Checkout</a>
            <button class="btn btn-outline-secondary" onclick="cart.clear()">Clear Cart</button>
        </div>
    <?php else: ?>
        <div class="cart-modal__empty">
            <i class="bi bi-cart-x cart-modal__empty-icon"></i>
            <p class="cart-modal__empty-text">Your cart is empty</p>
            <a href="/catalog" class="btn btn-primary">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>
