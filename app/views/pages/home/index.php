<main class="main home-page">
    <?php if (!empty($advertisedProducts)): ?>
        <section class="hero">
            <div class="container">
                <div class="hero__slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($advertisedProducts as $product): ?>
                            <div class="swiper-slide">
                                <div class="hero-slide">
                                    <div class="hero-slide__content">
                                        <h2 class="hero-slide__title"><?= h($product->title) ?></h2>
                                        <p class="hero-slide__description"><?= h($product->ad_description) ?></p>
                                        <a href="/product/<?= $product->alias ?>" class="btn btn-primary btn-lg">Learn More</a>
                                    </div>
                                    <div class="hero-slide__image">
                                        <img src="<?= getImage($product->img) ?>" alt="<?= h($product->title) ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="features" data-aos="fade-up">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card">
                        <div class="feature-card__icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h3 class="feature-card__title">24/7 Support</h3>
                        <p class="feature-card__text">Professional technical support</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card">
                        <div class="feature-card__icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-card__title">Secure Payments</h3>
                        <p class="feature-card__text">100% secure payment processing</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card">
                        <div class="feature-card__icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h3 class="feature-card__title">Easy Returns</h3>
                        <p class="feature-card__text">14-day money-back guarantee</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card">
                        <div class="feature-card__icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h3 class="feature-card__title">Fast Delivery</h3>
                        <p class="feature-card__text">Free shipping over $500</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ($bestSellers): ?>
        <section class="bestsellers">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Best Sellers</h2>
                <div class="bestsellers__grid">
                    <div class="swiper bestsellers-slider" data-aos="fade-up">
                        <div class="swiper-wrapper">
                            <?php foreach ($bestSellers as $product): ?>
                                <div class="swiper-slide">
                                    <?php require APP . '/views/components/product-card/product-card.php'; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="categories" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">Product Categories</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="/category/laptops" class="category-card">
                        <div class="category-card__image">
                            <img src="/assets/images/categories/laptops.jpg" alt="Laptops">
                        </div>
                        <h3 class="category-card__title">Laptops</h3>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/category/components" class="category-card">
                        <div class="category-card__image">
                            <img src="/assets/images/categories/components.jpg" alt="Components">
                        </div>
                        <h3 class="category-card__title">Components</h3>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/category/accessories" class="category-card">
                        <div class="category-card__image">
                            <img src="/assets/images/categories/accessories.jpg" alt="Accessories">
                        </div>
                        <h3 class="category-card__title">Accessories</h3>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($brands)): ?>
        <section class="brands" data-aos="fade-up">
            <div class="container">
                <h2 class="section-title">Our Brands</h2>
                <div class="swiper brands-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ($brands as $brand): ?>
                            <div class="swiper-slide">
                                <a href="/brand/<?= $brand->alias ?>" class="brand-card">
                                    <img src="<?= getImage($brand->img) ?>" alt="<?= h($brand->title) ?>"
                                         class="brand-card__image">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>
