<?php

namespace app\controllers;

use computerShop\libs\Pagination;

class CatalogController extends AppController
{
    public function indexAction()
{
    $brands = \R::find('brand', "ORDER BY title");
    $categories = \R::find('categories', "parent_id IS NOT NULL ORDER BY name");

    // Get filters from request
    $selectedBrands = isset($_GET['brands']) ? array_map('intval', $_GET['brands']) : [];
    $selectedCategories = isset($_GET['categories']) ? array_map('intval', $_GET['categories']) : [];
    $priceRange = [
        'min' => isset($_GET['price_min']) ? floatval($_GET['price_min']) : null,
        'max' => isset($_GET['price_max']) ? floatval($_GET['price_max']) : null
    ];
    $sort = $_GET['sort'] ?? 'default';
    $view = $_GET['view'] ?? 'grid';

    // Build query
    $where = "status = '1'";
    $params = [];

    if ($selectedBrands) {
        $where .= " AND brand_id IN (" . \R::genSlots($selectedBrands) . ")";
        $params = array_merge($params, $selectedBrands);
    }

    if ($selectedCategories) {
        $where .= " AND category_id IN (" . \R::genSlots($selectedCategories) . ")";
        $params = array_merge($params, $selectedCategories);
    }

    if ($priceRange['min'] !== null) {
        $where .= " AND price >= ?";
        $params[] = $priceRange['min'];
    }

    if ($priceRange['max'] !== null) {
        $where .= " AND price <= ?";
        $params[] = $priceRange['max'];
    }

    // Add sorting
    $order = $this->getSortOrder($sort);

    // Get total count for pagination
    $total = \R::count('product', $where, $params);

    // Setup pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perpage = 12;
    $pagination = new Pagination($page, $perpage, $total);
    $start = $pagination->getStart();

    // Get products
    $products = \R::find('product',
        "$where $order LIMIT ? OFFSET ?",
        array_merge($params, [$perpage, $start])
    );

    $this->setMeta(
        'Product Catalog',
        'Browse our wide selection of computer hardware and accessories',
        'catalog,products,computer hardware'
    );

    $this->setData(compact(
        'products',
        'brands',
        'categories',
        'selectedBrands',
        'selectedCategories',
        'priceRange',
        'sort',
        'view',
        'pagination',
        'total'
    ));
}

    public function viewAction()
    {
        $alias = $this->route['alias'] ?? null;
        if (!$alias) {
            throw new \Exception("Category not found", 404);
        }

        $category = \R::findOne('categories', 'alias = ?', [$alias]);
        if (!$category) {
            throw new \Exception("Category not found", 404);
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 12;

        // Get total products in category
        $total = \R::count('product', 'category_id = ? AND status = "1"', [$category->id]);

        // Setup pagination
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        // Get products
        $products = \R::find('product',
            'category_id = ? AND status = "1" ORDER BY id DESC LIMIT ? OFFSET ?',
            [$category->id, $perpage, $start]
        );

        $brands = \R::find('brand', "ORDER BY title");

        $this->setMeta(
            "{$category->name} - Product Catalog",
            "Browse our selection of {$category->name}",
            "{$category->name},catalog,products"
        );

        $this->setData(compact('category', 'products', 'brands', 'pagination', 'total'));
    }

    protected function getSortOrder($sort): string
    {
        switch ($sort) {
            case 'price_asc':
                return 'ORDER BY price ASC';
            case 'price_desc':
                return 'ORDER BY price DESC';
            case 'name_asc':
                return 'ORDER BY title ASC';
            case 'name_desc':
                return 'ORDER BY title DESC';
            default:
                return 'ORDER BY id DESC';
        }
    }
}
