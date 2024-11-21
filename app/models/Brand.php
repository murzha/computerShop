<?php

namespace app\models;

class Brand extends AppModel
{

    public function getID($alias)
    {
        return \R::findOne('brand', 'alias = ?', [$alias]) ?? false;
    }

    public function getAllActive($limit = null)
    {
        $sql = "SELECT * FROM brand";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return \R::getAll($sql);
    }

    public function getBrandProducts($brandId, $limit = null)
    {
        $sql = "SELECT * FROM product WHERE brand_id = ?";
        $params = [$brandId];

        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }

        return \R::getAll($sql, $params);
    }
}
