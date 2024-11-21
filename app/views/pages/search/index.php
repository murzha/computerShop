<div class="search-page">
    <?php $this->loadComponent('breadcrumbs/breadcrumbs', [
        'items' => [['title' => 'Search Results']]
    ]); ?>

    <div class="container">
        <div class="search-header">
            <h1 class="search-header__title">
                Search Results for "<?= h($query) ?>"
            </h1>
            <?php if ($total): ?>
                <p class="search-header__count">
                    <?= $total ?> items found
                </p>
            <?php endif; ?>
        </div>

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
            <div class="search-empty">
                <i class="bi bi-search search-empty__icon"></i>
                <h2 class="search-empty__title">No results found</h2>
                <p class="search-empty__text">
                    We couldn't find any products matching your search "<?= h($query) ?>"
                </p>
                <div class="search-empty__suggestions">
                    <h3>Suggestions:</h3>
                    <ul>
                        <li>Check the spelling of your search terms</li>
                        <li>Try using more general keywords</li>
                        <li>Try searching for alternative terms</li>
                    </ul>
                </div>
                <a href="/catalog" class="btn btn-primary">Browse All Products</a>
            </div>
        <?php endif; ?>
    </div>
