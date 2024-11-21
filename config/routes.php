<?php

use computerShop\Router;

// Product routes
Router::add('^product/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action' => 'view']);

// Brand routes
Router::add('^brand/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Brand', 'action' => 'view']);
Router::add('^brands/?$', ['controller' => 'Brand', 'action' => 'index']);

// Catalog routes
Router::add('^catalog/?$', ['controller' => 'Catalog', 'action' => 'index']);
Router::add('^catalog/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Catalog', 'action' => 'view']); // Изменено с category на alias

// Cart routes
Router::add('^cart/?$', ['controller' => 'Cart', 'action' => 'index']);
Router::add('^cart/checkout/?$', ['controller' => 'Cart', 'action' => 'checkout']);
Router::add('^cart/success/(?P<order_id>[0-9]+)/?$', ['controller' => 'Cart', 'action' => 'success']);

// Search routes
Router::add('^search/?$', ['controller' => 'Search', 'action' => 'index']);
Router::add('^search/typeahead/?$', ['controller' => 'Search', 'action' => 'typeahead']);

// Other routes
Router::add('^contacts/?$', ['controller' => 'Contacts', 'action' => 'index']);
Router::add('^$', ['controller' => 'Home', 'action' => 'index']);

// Default route
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
