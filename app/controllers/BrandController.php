<?php

namespace app\controllers;

use app\models\Brand;
use computerShop\libs\Pagination;

class BrandController extends AppController
{

    public function viewAction()
    {
        $brands = \R::findAll('brand');
        $alias = $this->route['alias'];

        if ($alias == 'all') {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = 8;
            $total = \R::count('product');
            $pagination = new Pagination($page, $perPage, $total);
            $start = $pagination->getStart();

            $products = \R::findAll('product', "LIMIT ?, ?", [$start, $perPage]);
            $this->setMeta('Product Catalog', 'All computer hardware products', 'computer,hardware,catalog');
            $this->setData(compact('brands', 'products', 'pagination', 'total'));
        } else {
            $brand = new Brand();
            $brandData = $brand->getID($alias);

            if (!$brandData) {
                throw new \Exception('Brand not found', 404);
            }

            $brandId = $brandData['id'];
            $brandTitle = $brandData['title'];

            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = 8;
            $total = \R::count('product', "brand_id = ?", [$brandId]);
            $pagination = new Pagination($page, $perPage, $total);
            $start = $pagination->getStart();

            $products = \R::findAll('product', "brand_id = ? LIMIT ?, ?", [$brandId, $start, $perPage]);

            $this->setMeta($brandTitle . ' Products', 'Products from ' . $brandTitle, $brandTitle . ',computer,hardware');
            $this->setData(compact('brandTitle', 'brands', 'products', 'pagination', 'total'));
        }
    }
}
