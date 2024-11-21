// Core modules
import {EventEmitter} from './core/EventEmitter';
import {Api} from './core/Api';
import {Store} from './core/Store';
import {Notification} from './core/Notification';

// Feature modules
import {Cart} from './features/Cart';
import {Catalog} from './features/Catalog';
import {ProductGallery} from './features/ProductGallery';
import {Forms} from './features/Forms';

// Initialize app
class App {
    constructor() {
        this.store = new Store();
        this.api = new Api();
        this.notifications = new Notification();

        // Initialize features
        this.cart = new Cart(this.store, this.api, this.notifications);
        this.catalog = new Catalog(this.store, this.api);
        this.productGallery = new ProductGallery();
        this.forms = new Forms(this.notifications);

        this.init();
    }

    init() {
        // Initialize global event listeners
        document.addEventListener('DOMContentLoaded', () => {
            this.initializeModules();
        });
    }

    initializeModules() {
        const currentPage = document.body.dataset.page;

        // Initialize modules based on current page
        switch (currentPage) {
            case 'catalog':
                this.catalog.init();
                break;
            case 'product':
                this.productGallery.init();
                break;
        }

        // Always initialize cart
        this.cart.init();
        // Always initialize forms
        this.forms.init();
    }
}

// Create app instance
window.app = new App();
