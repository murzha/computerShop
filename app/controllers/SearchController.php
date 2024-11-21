<?php

namespace app\controllers;

use computerShop\libs\Pagination;

class SearchController extends AppController
{

    public function typeaheadAction()
    {
        if ($this->isAjax()) {
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;
            if ($query) {
                $products = \R::getAll('SELECT p.id, p.title, c.name as category 
                    FROM product p 
                    LEFT JOIN categories c ON c.id = p.category_id 
                    WHERE p.title LIKE ? AND p.status = "1" 
                    LIMIT 11',
                    ["%{$query}%"]
                );
                echo json_encode($products);
            }
            die;
        }
    }

    public function indexAction()
    {
        $brands = \R::find('brand', "status = '1' LIMIT 10");
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;
        $category = !empty($_GET['category']) ? (int)$_GET['category'] : null;

        if ($query) {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = 12;

            $sql = "SELECT DISTINCT p.* FROM product p 
                   LEFT JOIN product_specification_value psv ON p.id = psv.product_id 
                   WHERE p.status = '1' AND (
                       p.title LIKE :query OR 
                       p.content LIKE :query OR 
                       psv.value LIKE :query
                   )";

            $params = [":query" => "%{$query}%"];

            if ($category) {
                $sql .= " AND p.category_id = :category";
                $params[":category"] = $category;
            }

            $total = \R::getCell("SELECT COUNT(*) FROM ($sql) as t", $params);

            $pagination = new Pagination($page, $perPage, $total);
            $start = $pagination->getStart();

            $sql .= " LIMIT $start, $perPage";
            $products = \R::getAll($sql, $params);
            $products = \R::convertToBeans('product', $products);
        }

        $this->setMeta(
            'Search: ' . h($query),
            'Computer parts and accessories search results',
            'search,computer,parts,accessories'
        );

        $this->setData(compact('products', 'query', 'brands', 'pagination', 'total', 'category'));
    }
}
