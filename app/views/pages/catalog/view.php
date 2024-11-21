<div class="catalog-page">
    <?php $this->loadComponent('breadcrumbs/breadcrumbs', [
        'items' => [
            ['title' => 'Catalog', 'url' => '/catalog'],
            ['title' => $category->name]
        ]
    ]); ?>

    <div class="container">
        <div class="category-header">
            <h1 class="category-header__title"><?= h($category->name) ?></h1>
            <?php if ($category->description): ?>
                <div class="category-header__description">
                    <?= $category->description ?>
                </div>
            <?php endif; ?>

            <?php if ($total): ?>
                <div class="category-header__count">
                    <?= $total ?> products found
                </div>
            <?php endif; ?>
        </div>

        <div class="category-content">
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
                <div class="category-empty">
                    <i class="bi bi-box category-empty__icon"></i>
                    <h2 class="category-empty__title">No products found</h2>
                    <p class="category-empty__text">
                        There are no products in this category at the moment.
                    </p>
                    <a href="/catalog" class="btn btn-primary">Browse All Products</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
