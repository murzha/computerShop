<div class="header">
    <div class="header__top">
        <div class="container">
            <div class="header__wrapper">
                <div class="header__logo">
                    <a href="/" class="logo">
                        <span class="logo__text">Computer Shop</span>
                    </a>
                </div>
                
                <div class="header__search">
                    <form class="search-form" action="/search" method="get" autocomplete="off">
                        <div class="search-form__wrapper">
                            <input 
                                type="text" 
                                class="search-form__input form-control" 
                                id="typeahead" 
                                name="s" 
                                placeholder="Search products..."
                            >
                            <button class="search-form__button btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="header__cart">
                    <div class="cart-mini">
                        <button class="cart-mini__button" onclick="getCart(); return false;">
                            <i class="bi bi-cart3"></i>
                            <span class="cart-mini__count">
                                <?= !empty($_SESSION['cart.quantity']) ? $_SESSION['cart.quantity'] : '0' ?>
                            </span>
                        </button>
                        <div class="cart-mini__total">
                            <?= !empty($_SESSION['cart.sum']) ? '$' . $_SESSION['cart.sum'] : '$0' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="header__nav navbar navbar-expand-lg bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Catalog
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/brand/all">All Products</a></li>
                            <?php if (!empty($brands)): ?>
                                <li><hr class="dropdown-divider"></li>
                                <?php foreach ($brands as $brand): ?>
                                    <li>
                                        <a class="dropdown-item" href="/brand/<?= $brand->alias ?>">
                                            <?= $brand->title ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contacts">Contacts</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
