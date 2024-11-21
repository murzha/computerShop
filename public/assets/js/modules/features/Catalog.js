export class Catalog {
    constructor(store, api) {
        this.store = store;
        this.api = api;
        this.productsContainer = document.querySelector('.product-grid');
        this.filterForm = document.querySelector('.catalog-filter');

        // Bind methods
        this.handleFilterChange = this.handleFilterChange.bind(this);
        this.handleSortChange = this.handleSortChange.bind(this);
        this.handleViewChange = this.handleViewChange.bind(this);
    }

    init() {
        if (!this.productsContainer) return;

        // Initialize event listeners
        this.initializeEventListeners();

        // Initialize Swiper for category slides if present
        this.initializeSwiper();

        // Subscribe to store changes
        this.store.on('stateChange', (event) => {
            if (event.path.startsWith('catalog')) {
                this.updateUI();
            }
        });

        // Load initial state
        this.loadInitialState();
    }

    initializeEventListeners() {
        // Filter form
        this.filterForm?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleFilterSubmit(new FormData(e.target));
        });

        // Price range inputs
        const priceInputs = document.querySelectorAll('.price-filter input');
        priceInputs.forEach(input => {
            input.addEventListener('change', () => this.handlePriceRangeChange());
        });

        // Sort select
        document.querySelector('.catalog-sorting select')?.addEventListener('change', (e) => {
            this.handleSortChange(e.target.value);
        });

        // View toggle buttons
        document.querySelectorAll('.catalog-view__btn').forEach(btn => {
            btn.addEventListener('click', () => this.handleViewChange(btn.dataset.view));
        });
    }

    initializeSwiper() {
        const categorySlider = document.querySelector('.category-slider');
        if (categorySlider) {
            new Swiper(categorySlider, {
                slidesPerView: 'auto',
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 2,
                    },
                    576: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 5,
                    }
                }
            });
        }
    }

    async loadInitialState() {
        // Get URL parameters
        const params = new URLSearchParams(window.location.search);
        const initialFilters = {
            brand: params.get('brand'),
            priceRange: {
                min: params.get('price_min'),
                max: params.get('price_max')
            },
            sort: params.get('sort') || 'default'
        };

        this.store.updateFilters(initialFilters);
        await this.fetchProducts();
    }

    async handleFilterSubmit(formData) {
        const filters = {
            brand: formData.get('brand'),
            priceRange: {
                min: formData.get('price_min'),
                max: formData.get('price_max')
            }
        };

        this.store.updateFilters(filters);
        await this.fetchProducts();
        this.updateUrl();
    }

    handlePriceRangeChange() {
        const minInput = document.querySelector('.price-filter input[placeholder="Min"]');
        const maxInput = document.querySelector('.price-filter input[placeholder="Max"]');

        this.store.updateFilters({
            priceRange: {
                min: minInput?.value || null,
                max: maxInput?.value || null
            }
        });
    }

    handleSortChange(value) {
        this.store.setState('catalog.filters.sort', value);
        this.fetchProducts();
        this.updateUrl();
    }

    handleViewChange(view) {
        this.store.setView(view);
        this.updateUI();
    }

    async fetchProducts() {
        try {
            const {filters} = this.store.getState().catalog;
            const response = await this.api.getProducts(filters);

            if (response.success) {
                this.updateProductsGrid(response.products);
                this.updatePagination(response.pagination);
            }
        } catch (error) {
            console.error('Failed to fetch products:', error);
        }
    }

    updateProductsGrid(products) {
        if (!this.productsContainer) return;

        this.productsContainer.innerHTML = products.length ?
            products.map(product => this.createProductCard(product)).join('') :
            this.createEmptyState();
    }

    updatePagination(pagination) {
        const paginationContainer = document.querySelector('.pagination-wrapper');
        if (paginationContainer && pagination) {
            paginationContainer.innerHTML = pagination;
        }
    }

    updateUI() {
        const {view} = this.store.getState().catalog;

        // Update view buttons
        document.querySelectorAll('.catalog-view__btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.view === view);
        });

        // Update products container class
        this.productsContainer?.classList.toggle('product-grid--list', view === 'list');
    }

    updateUrl() {
        const {filters} = this.store.getState().catalog;
        const url = new URL(window.location.href);

        // Update URL parameters
        Object.entries(filters).forEach(([key, value]) => {
            if (value) {
                if (typeof value === 'object') {
                    Object.entries(value).forEach(([subKey, subValue]) => {
                        if (subValue) {
                            url.searchParams.set(`${key}_${subKey}`, subValue);
                        } else {
                            url.searchParams.delete(`${key}_${subKey}`);
                        }
                    });
                } else {
                    url.searchParams.set(key, value);
                }
            } else {
                url.searchParams.delete(key);
                if (key === 'priceRange') {
                    url.searchParams.delete('price_min');
                    url.searchParams.delete('price_max');
                }
            }
        });

        // Update URL without reloading the page
        window.history.pushState({}, '', url);
    }

    createEmptyState() {
        return `
            <div class="catalog-empty">
                <i class="bi bi-search catalog-empty__icon"></i>
                <h2 class="catalog-empty__title">No products found</h2>
                <p class="catalog-empty__text">Try adjusting your search or filter criteria</p>
                <a href="/catalog" class="btn btn-primary">View All Products</a>
            </div>
        `;
    }

    createProductCard(product) {
        // This uses the product-card component template
        // The actual implementation would be handled by the server-side template
        return `<div class="product-grid__item" data-product-id="${product.id}">
            ${product.html}
        </div>`;
    }
}
