<div class="product-card">
    <div class="product-card__image">
        <a href="/product/<?= $product->alias ?>" class="product-card__link">
            <img
                src="<?= getImage($product->img) ?>"
                alt="<?= h($product->title) ?>"
                class="product-card__img"
            >
        </a>
        <?php if ($product->old_price > 0): ?>
            <div class="product-card__badge">
                <?= getDiscountPercent($product->old_price, $product->price) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="product-card__content">
        <h3 class="product-card__title">
            <a href="/product/<?= $product->alias ?>">
                <?= strlen($product->title) > 50
                    ? cropText($product->title, 50)
                    : $product->title ?>
            </a>
        </h3>

        <div class="product-card__price">
            <?php if ($product->old_price > 0): ?>
                <span class="product-card__price-old">$<?= $product->old_price ?></span>
            <?php endif; ?>
            <span class="product-card__price-current">$<?= $product->price ?></span>
        </div>

        <button
            class="product-card__button btn btn-primary"
            data-id="<?= $product->id ?>"
            onclick="cart.addToCart(this)">
            Add to Cart
        </button>
    </div>
</div>
