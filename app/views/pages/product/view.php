<div class="product-page">
    <?php if ($product): ?>
        <?php $this->loadComponent('breadcrumbs/breadcrumbs', [
            'items' => [
                ['title' => 'Catalog', 'url' => '/catalog'],
                ['title' => $product->title]
            ]
        ]); ?>

        <div class="container">
            <div class="product-main">
                <div class="product-gallery">
                    <div class="swiper product-gallery__main">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="<?= getImage($product->img) ?>"
                                     alt="<?= h($product->title) ?>"
                                     class="product-gallery__image">
                            </div>
                            <?php if ($gallery): ?>
                                <?php foreach ($gallery as $item): ?>
                                    <div class="swiper-slide">
                                        <img src="<?= getImage($item->img) ?>"
                                             alt="<?= h($product->title) ?>"
                                             class="product-gallery__image">
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <?php if ($gallery): ?>
                        <div class="swiper product-gallery__thumbs">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="<?= getImage($product->img) ?>"
                                         alt="<?= h($product->title) ?>">
                                </div>
                                <?php foreach ($gallery as $item): ?>
                                    <div class="swiper-slide">
                                        <img src="<?= getImage($item->img) ?>"
                                             alt="<?= h($product->title) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-info">
                    <h1 class="product-info__title"><?= h($product->title) ?></h1>

                    <?php if ($product->stock_quantity > 0): ?>
                        <div class="product-info__stock product-info__stock--in">
                            <i class="bi bi-check-circle"></i> In Stock
                        </div>
                    <?php else: ?>
                        <div class="product-info__stock product-info__stock--out">
                            <i class="bi bi-x-circle"></i> Out of Stock
                        </div>
                    <?php endif; ?>

                    <div class="product-info__price">
                        <?php if ($product->old_price > 0): ?>
                            <span class="product-info__price-old">$<?= $product->old_price ?></span>
                        <?php endif; ?>
                        <span class="product-info__price-current">$<?= $product->price ?></span>
                        <?php if ($product->old_price > 0): ?>
                            <span class="product-info__discount">
                                -<?= round((($product->old_price - $product->price) / $product->old_price) * 100) ?>%
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="product-info__description">
                        <?= $product->content ?>
                    </div>

                    <?php if ($specData): ?>
                        <div class="product-specs">
                            <h3 class="product-specs__title">Specifications</h3>
                            <div class="specs-table">
                                <?php foreach ($specData as $spec): ?>
                                    <div class="specs-table__row">
                                        <div class="specs-table__label"><?= $spec['name'] ?></div>
                                        <div class="specs-table__value">
                                            <?= $spec['value'] ?>
                                            <?= $spec['unit'] ? $spec['unit'] : '' ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($product->stock_quantity > 0): ?>
                        <div class="product-actions">
                            <div class="quantity-control quantity-control--large">
                                <button class="quantity-control__button" onclick="cart.decreaseQuantity()">-</button>
                                <input type="number" id="productQuantity" class="quantity-control__input" value="1" min="1" max="<?= $product->stock_quantity ?>">
                                <button class="quantity-control__button" onclick="cart.increaseQuantity()">+</button>
                            </div>
                            <button class="btn btn-primary btn-lg product-actions__cart"
                                    onclick="cart.addToCart(<?= $product->id ?>)">
                                Add to Cart
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($related): ?>
                <section class="related-products">
                    <h2 class="section-title">Related Products</h2>
                    <div class="swiper related-slider">
                        <div class="swiper-wrapper">
                            <?php foreach ($related as $product): ?>
                                <div class="swiper-slide">
                                    <?php $this->loadComponent('product-card/product-card', compact('product')); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
