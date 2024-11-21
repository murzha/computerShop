<?php

namespace app\controllers;

use app\models\Product;
use app\models\Specification;

class ProductController extends AppController
{

    public function viewAction()
    {
        $alias = $this->route['alias'];
        $brands = \R::findAll('brand');

        // Get product without status check
        $product = \R::findOne('product', "alias = ?", [$alias]);
        if (!$product) {
            throw new \Exception("Product not found", 404);
        }

        // Get product specifications
        $specifications = \R::findAll('product_specification_value', 'product_id = ?', [$product->id]);
        $specData = [];
        foreach ($specifications as $spec) {
            $specInfo = \R::findOne('specification', 'id = ?', [$spec->specification_id]);
            if ($specInfo) {
                $specData[] = [
                    'name' => $specInfo->name,
                    'value' => $spec->value,
                    'unit' => $specInfo->unit
                ];
            }
        }

        // Get product images
        $gallery = \R::findAll('gallery', 'product_id = ?', [$product->id]);
        $mainImg = \R::findOne('gallery', 'product_id = ?', [$product->id]);

        // Handle recently viewed
        $p_model = new Product();
        $p_model->setRecentlyViewed($product->id);

        // Get related products
        $related = $p_model->getRelated($product->id, 6);

        // Get recently viewed products
        $r_viewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if ($r_viewed) {
            $recentlyViewed = \R::find('product', 'id IN (' . \R::genSlots($r_viewed) . ') LIMIT 6', $r_viewed);
        }

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->setData(compact('brands', 'product', 'gallery', 'mainImg', 'recentlyViewed', 'specData', 'related'));
    }

    public function getSpecificationsAction()
    {
        if ($this->isAjax()) {
            $product_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
            if (!$product_id) {
                return false;
            }

            $specs = \R::findAll('product_specification_value', 'product_id = ?', [$product_id]);
            if ($specs) {
                $specData = [];
                foreach ($specs as $spec) {
                    $specInfo = \R::findOne('specification', 'id = ?', [$spec->specification_id]);
                    if ($specInfo) {
                        $specData[] = [
                            'name' => $specInfo->name,
                            'value' => $spec->value,
                            'unit' => $specInfo->unit
                        ];
                    }
                }
                echo json_encode($specData);
            }
            die;
        }
    }
}
