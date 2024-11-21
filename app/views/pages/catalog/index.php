<div class="catalog-page">
    <?php $this->loadComponent('breadcrumbs/breadcrumbs', [
        'items' => [['title' => 'Catalog']]
    ]); ?>

    <div class="container">
        <div class="catalog-grid">
            <aside class="catalog-sidebar">
                <div class="catalog-filter">
                    <form id="filter-form" class="filter-form">
                        <?php if ($categories): ?>
                            <div class="filter-section">
                                <h3 class="filter-section__title">Categories</h3>
                                <ul class="filter-list">
                                    <?php foreach ($categories as $category): ?>
                                        <li class="filter-list__item">
                                            <label class="custom-checkbox">
                                                <input type="checkbox" name="categories[]"
                                                       value="<?= $category->id ?>"
                                                    <?= in_array($category->id, $selectedCategories ?? []) ? 'checked' : '' ?>>
                                                <span class="custom-checkbox__text"><?= h($category->name) ?></span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if ($brands): ?>
                            <div class="filter-section">
                                <h3 class="filter-section__title">Brands</h3>
                                <ul class="filter-list">
                                    <?php foreach ($brands as $brand): ?>
                                        <li class="filter-list__item">
                                            <label class="custom-checkbox">
                                                <input type="checkbox" name="brands[]"
                                                       value="<?= $brand->id ?>"
                                                    <?= in_array($brand->id, $selectedBrands ?? []) ? 'checked' : '' ?>>
                                                <span class="custom-checkbox__text"><?= h($brand->title) ?></span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="filter-section">
                            <h3 class="filter-section__title">Price Range</h3>
                            <div class="price-range">
                                <div class="price-range__inputs">
                                    <input type="number" name="price_min" class="form-control"
                                           placeholder="Min" value="<?= $priceRange['min'] ?? '' ?>">
                                    <span>-</span>
                                    <input type="number" name="price_max" class="form-control"
                                           placeholder="Max" value="<?= $priceRange['max'] ?? '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                            <button type="reset" class="btn btn-outline-secondary w-100 mt-2">Reset</button>
                        </div>
                    </form>
                </div>
            </aside>

            <div class="catalog-content">
                <div class="catalog-toolbar">
                    <div class="catalog-toolbar__info">
                        <?php if ($total): ?>
                            <span><?= $total ?> products found</span>
                        <?php endif; ?>
                    </div>

                    <div class="catalog-toolbar__controls">
                        <select class="form-select" id="sort-select">
                            <option value="default">Default sorting</option>
                            <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>
                                Price: Low to High
                            </option>
                            <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>
                                Price: High to Low
                            </option>
                            <option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>
                                Name: A to Z
                            </option>
                        </select>

                        <div class="view-switcher">
                            <button class="view-switcher__btn <?= $view === 'grid' ? 'active' : '' ?>"
                                    data-view="grid">
                                <i class="bi bi-grid"></i>
                            </button>
                            <button class="view-switcher__btn <?= $view === 'list' ? 'active' : '' ?>"
                                    data-view="list">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <?php if (!empty($products)): ?>
                    <div class="product-grid <?= $view === 'list' ? 'product-grid--list' : '' ?>">
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
                    <div class="catalog-empty">
                        <i class="bi bi-search catalog-empty__icon"></i>
                        <h2 class="catalog-empty__title">No products found</h2>
                        <p class="catalog-empty__text">Try adjusting your filters</p>
                        <button class="btn btn-primary" onclick="document.getElementById('filter-form').reset()">
                            Reset Filters
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
