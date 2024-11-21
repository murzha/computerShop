<?php

namespace app\models;

class Product extends AppModel
{

    public function setRecentlyViewed($id): bool
    {
        $recentlyViewed = $this->getAllRecentlyViewed();

        if (!$recentlyViewed) {
            setcookie('recentlyViewed', $id, time() + 3600 * 24, '/');
            return true;
        }

        $recentlyViewed = explode('.', $recentlyViewed);
        if (!in_array($id, $recentlyViewed)) {
            $recentlyViewed[] = $id;
            $recentlyViewed = implode('.', $recentlyViewed);
            setcookie('recentlyViewed', $recentlyViewed, time() + 3600 * 24, '/');
        }
        return true;
    }

    public function getRecentlyViewed()
    {
        if (!empty($_COOKIE['recentlyViewed'])) {
            $recentlyViewed = explode('.', $_COOKIE['recentlyViewed']);
            return array_slice($recentlyViewed, -6);
        }
        return false;
    }

    public function getAllRecentlyViewed()
    {
        return $_COOKIE['recentlyViewed'] ?? false;
    }

    public function getHits($limit): array
    {
        return \R::find('product', "hit = '1' AND status = '1' LIMIT ?", [$limit]);
    }

    public function getRelated($product_id, $limit): array
    {
        return \R::find('product',
            "category_id = (SELECT category_id FROM product WHERE id = ?) 
             AND id != ? AND status = '1' LIMIT ?",
            [$product_id, $product_id, $limit]);
    }
}
