<?php

namespace App\Repository;

use App\Core\Database;
use App\Model\Order;

class OrderRepository
{

    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }

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

        /*$list = [];
        $orderList= [];
        $db = Database::getInstance();
        $statement = $db->prepare("select o.id, concat(u.last_name, ' ', u.first_name) as full_name,
       p.product_name,
       op.quantity,
       (op.quantity * p.product_price) as total_price from user u
         inner join `order` o on u.id = o.user_id
         inner join order_product op on o.id = op.order_id
         inner join product p on op.product_id = p.id;");
        $statement->execute();
        $orders = $statement->fetchAll();
        foreach ($orders as $order) {
            array_push($list, $order);
        }

        return $list;*/

    }



}

