<?php

namespace app\models;

class Cart extends AppModel
{

    public function addToCart($product, $quantity = 1)
    {
        if (!$product) {
            return false;
        }

        $quantity = (int)$quantity;
        if ($quantity < 1) {
            $quantity = 1;
        }

        $id = $product->id;
        $price = floatval($product->price);

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'quantity' => $quantity,
                'title' => $product->title,
                'alias' => $product->alias,
                'price' => $price,
                'img' => $product->img,
            ];
        }

        $_SESSION['cart.quantity'] = isset($_SESSION['cart.quantity']) ?
            $_SESSION['cart.quantity'] + $quantity : $quantity;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ?
            $_SESSION['cart.sum'] + $quantity * $price : $quantity * $price;

        return true;
    }

    public function deleteItem($id)
    {
        if (!isset($_SESSION['cart'][$id])) {
            return false;
        }

        $qtyMinus = $_SESSION['cart'][$id]['quantity'];
        $sumMinus = $_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price'];

        $_SESSION['cart.quantity'] -= $qtyMinus;
        $_SESSION['cart.sum'] -= $sumMinus;

        unset($_SESSION['cart'][$id]);
        return true;
    }

    public function clear()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.quantity']);
        unset($_SESSION['cart.sum']);
    }
}
