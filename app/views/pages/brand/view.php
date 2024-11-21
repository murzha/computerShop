<div class="brand-page">
    <?php $this->loadComponent('breadcrumbs/breadcrumbs', [
        'items' => [
            ['title' => 'Brands', 'url' => '/brands'],
            ['title' => $brand->title]
        ]
    ]); ?>

    <div class="container">
        <div class="brand-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="brand-header__title"><?= h($brand->title) ?> Products</h1>
                    <?php if (!empty($brand->description)): ?>
                        <div class="brand-header__description">
                            <?= $brand->description ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($brand->img)): ?>
                    <div class="col-md-6">
                        <div class="brand-header__image">
                            <img src="<?= getImage($brand->img, 'brands') ?>"
                                 alt="<?= h($brand->title) ?>"
                                 class="img-fluid">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="brand-products">
            <?php if (!empty($products)): ?>
                <div class="product-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-grid__item">
                            <?php $this->loadComponent('product-card/product-card', compact('product')); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (isset($pagination)): ?>
                    <?php $this->loadComponent('pagination/pagination', compact('pagination')); ?>
                <?php endif; ?>
            <?php else: ?>
                <div class="brand-products__empty">
                    <div class="text-center py-5">
                        <i class="bi bi-box fs-1 text-muted"></i>
                        <h3 class="mt-3">No products found</h3>
                        <p class="text-muted">There are no products available from this brand at the moment.</p>
                        <a href="/catalog" class="btn btn-primary">Browse All Products</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
