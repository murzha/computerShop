<?php

namespace app\models;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Order extends AppModel
{

    public static function saveOrder($data)
    {
        $order = \R::dispense('order');

        $order->name = $data['name'];
        $order->user_email = $data['email'];
        $order->address = $data['address'];
        $order->note = $data['comment'] ?? '';
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date('Y-m-d H:i:s');
        $order->status = 'new';

        $order_id = \R::store($order);

        if ($order_id) {
            self::saveOrderProducts($order_id);
            return $order_id;
        }
        return false;
    }

    protected static function saveOrderProducts($order_id)
    {
        $values = [];
        foreach ($_SESSION['cart'] as $product_id => $product) {
            $values[] = "($order_id, 
                        " . (int)$product_id . ", 
                        " . (int)$product['quantity'] . ", 
                        '" . \R::getDatabaseAdapter()
                    ->getDatabase()
                    ->quote($product['title']) . "', 
                        " . floatval($product['price']) . ")";
        }

        if (!empty($values)) {
            $sql = "INSERT INTO order_product (order_id, product_id, quantity, title, price) 
                   VALUES " . implode(', ', $values);
            \R::exec($sql);
        }
    }

    public static function mailOrder($order_id, $user_email): bool
    {
        $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', '2525', 'tls'))
            ->setUsername('8d1a8f2ff91ae2')
            ->setPassword('21ae5e7797af5a');

        $mailer = new Swift_Mailer($transport);

        ob_start();
        require APP . '/views/mail/mail_order.php';
        $body = ob_get_clean();

        $message = (new Swift_Message("Order #{$order_id} confirmation"))
            ->setFrom(['noreply@techzone.com' => 'Computer Shop'])
            ->setTo($user_email)
            ->setBody($body, 'text/html');

        $result = $mailer->send($message);

        if ($result) {
            unset($_SESSION['cart']);
            unset($_SESSION['cart.quantity']);
            unset($_SESSION['cart.sum']);
            $_SESSION['success'] = 'Thank you for your order. Our manager will contact you shortly.';
            return true;
        }
        return false;
    }
}
