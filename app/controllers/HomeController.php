<?php

namespace app\controllers;

class HomeController extends AppController
{
    public function indexAction()
    {
        // Get active brands with images
        $brands = \R::find('brand', "LIMIT 10");

        // Get bestsellers that are in stock and active
        $bestSellers = \R::find('product', "hit = '1' AND status = '1' AND stock_quantity > 0 LIMIT 12");

        // Get advertised products
        $advertisedProducts = \R::find('product', "advertise = '1' AND status = '1'");

        // Filter out products without images
        foreach ($advertisedProducts as $id => $product) {
            if (empty($product->img) ||
                empty($product->ad_img) ||
                !file_exists(WWW . "/uploads/images/{$product->img}") ||
                !file_exists(WWW . "/uploads/images/{$product->ad_img}")) {
                \R::exec("UPDATE product SET advertise = '0' WHERE id = ?", [$id]);
                unset($advertisedProducts[$id]);
            }
        }

        $this->setMeta(
            'Computer Hardware Store',
            'Buy computer hardware and accessories',
            'computer,hardware,store'
        );

        $this->setData(compact('bestSellers', 'brands', 'advertisedProducts'));
    }
}
