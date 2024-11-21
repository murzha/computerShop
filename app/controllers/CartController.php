<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Order;

class CartController extends AppController
{
    public function viewAction()
    {
        $brands = \R::find('brand', "LIMIT 10");
        $this->setMeta('Shopping Cart', 'Computer hardware shopping cart', 'cart,computer,hardware');
        $this->setData(compact('brands'));
    }

    public function addAction()
    {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        $quantity = !empty($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

        if (!$id) {
            return $this->error('Invalid product ID');
        }

        $product = \R::findOne('product', 'id = ?', [$id]);
        if (!$product) {
            return $this->error('Product not found');
        }

        $cart = new Cart();
        if ($cart->addToCart($product, $quantity)) {
            if ($this->isAjax()) {
                $this->loadView('cart_modal');
            }
            $this->success('Product added to cart');
        }

        redirect();
    }

    public function showAction()
    {
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function deleteAction()
    {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) {
            return $this->error('Invalid product ID');
        }

        if (isset($_SESSION['cart'][$id])) {
            $cart = new Cart();
            $cart->deleteItem($id);
        }

        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function clearAction()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.quantity']);
        unset($_SESSION['cart.sum']);

        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function checkoutAction()
    {
        if (!empty($_POST)) {
            if (!empty($_SESSION['cart'])) {
                $data = [
                    'name' => htmlspecialchars(trim($_POST['order-customer-name'])),
                    'email' => filter_var(trim($_POST['order-email']), FILTER_SANITIZE_EMAIL),
                    'address' => htmlspecialchars(trim($_POST['order-address'])),
                    'comment' => !empty($_POST['order-comment']) ?
                        htmlspecialchars(trim($_POST['order-comment'])) : ''
                ];

                $errors = $this->validateOrderData($data);

                if (empty($errors)) {
                    $order_id = Order::saveOrder($data);
                    if ($order_id) {
                        Order::mailOrder($order_id, $data['email']);
                        $this->success('Order placed successfully');
                        redirect();
                    }
                }
                $this->setData(compact('errors'));
            }
        }
        redirect();
    }

    protected function validateOrderData($data): array
    {
        $errors = [];
        if (strlen($data['name']) < 2) {
            $errors[] = 'Name must be at least 2 characters long';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address';
        }
        if (strlen($data['address']) < 5) {
            $errors[] = 'Please enter a valid delivery address';
        }
        return $errors;
    }

    protected function error($message)
    {
        if ($this->isAjax()) {
            echo json_encode(['error' => $message]);
            die;
        }
        $_SESSION['error'] = $message;
        redirect();
    }

    protected function success($message)
    {
        if ($this->isAjax()) {
            echo json_encode(['success' => $message]);
            die;
        }
        $_SESSION['success'] = $message;
    }
}
