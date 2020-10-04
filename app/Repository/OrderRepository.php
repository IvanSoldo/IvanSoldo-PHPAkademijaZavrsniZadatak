<?php

namespace App\Repository;

use App\Core\Database;
use App\Model\Order;

class OrderRepository
{

    public function insertOrder()
    {
        $db = Database::getInstance();
        $statement = $db->prepare('insert into `order` (user_id) VALUE (:userId);');
        $statement->bindValue('userId', intval($_SESSION['userId']));
        $statement->execute();
        foreach ($_SESSION['cart'] as $product) {
            $product = unserialize($product);
            $statement = $db->prepare('insert into order_product (order_id, product_id,quantity) VALUE (:order_id,:productId,:quantity);');
            $statement->bindValue('order_id', $this->getOrderId());
            $statement->bindValue('productId', intval($product->id));
            $statement->bindValue('quantity', intval($product->quantity));
            $statement->execute();
        }
    }

    private function getOrderId()
    {
        $db = Database::getInstance();
        $statement = $db->prepare('select id from `order` where user_id = :userId order by order_date desc;');
        $user = intval($_SESSION['userId']);
        $statement->bindValue('userId', $user);
        $statement->execute();
        $id = $statement->fetch($db::FETCH_ASSOC);
        $orderId = $id['id'];
        $orderId = intval($orderId);
        return $orderId;
    }

    public function getAllOrders()
    {
        $orders = [];
        $db = Database::getInstance();
        $statement = $db->prepare('select o.id, o.order_date, concat (u.last_name, " ", u.first_name) as full_name, a.address, a.postal_code, a.city_name
                                            from `order` o
                                                inner join user u on o.user_id = u.id
                                                inner join address a on u.address_id = a.id;');
        $statement->execute();
        foreach ($statement->fetchAll() as $order) {
            $orders[] = new Order([
                'id'=>$order->id,
                'orderDate'=>$order->order_date,
                'fullName'=>$order->full_name,
                'orderAddress'=> $order->address . ', ' . $order->postal_code . ' ' . $order->city_name
            ]);
        }
        return $orders;
    }
}

