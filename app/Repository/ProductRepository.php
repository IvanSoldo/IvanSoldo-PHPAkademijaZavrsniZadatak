<?php

namespace App\Repository;

use App\Core\Database;
use App\Model\Product;

class ProductRepository {

    private $product;

    public function __construct() {

    }

    public function doesProductExist($product)
    {
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT `product_name` FROM `product` where `product_name` = (?)', [$product]);
        $statement->execute([$product]);
        $fetched = $statement->rowCount();
        return (bool)$fetched;
    }

    public function checkIfProductExistById($id)
    {
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT `product_name` FROM `product` where `id` = (?) and product_active = 1', [$id]);
        $statement->execute([$id]);
        $fetched = $statement->rowCount();
        return (bool)$fetched;
    }

    public function getCategories() {
        $list = [];
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT `category_name` FROM `category`');
        $statement->execute();
        $categories = $statement->fetchAll();
        foreach ($categories as $category) {
          array_push($list, $category->category_name);
        }
        return $list;
    }

    public function getProducts() {
        $list = [];
        $db = Database::getInstance();
        $statement = $db->prepare('select * from product');
        $statement->execute();
        $products = $statement->fetchAll();
        foreach ($products as $product) {
            array_push($list, $product);
        }
        return $list;
    }

    public function getFilteredProducts() {
        $list = [];
        $db = Database::getInstance();
        $statement = $db->prepare('select * from product where product_active = 1');
        $statement->execute();
        $products = $statement->fetchAll();
        foreach ($products as $product) {
            array_push($list, $product);
        }
        return $list;
    }


    public function insertProduct($data) {
        $db=Database::getInstance();
        $statement = $db->prepare('insert into product (product_name, product_price, product_description, product_picture)
                                            values (:productName, :productPrice, :productDescription, :productPicture);');
        $statement->bindValue('productName', $data['productName']);
        $statement->bindValue('productPrice', $data['productPrice']);
        $statement->bindValue('productDescription', $data['productDescription']);
        $statement->bindValue('productPicture', file_get_contents($data['productImageBlob']));
        $statement->execute();
        $productId = $this->getProductId($data['productName']);
        foreach ($data['chosenCategories'] as $category) {
            $statement = $db->prepare('insert into product_category (category_id,product_id) VALUES (:categoryId,:productId);');
            $statement->bindValue('categoryId', $this->getCategoryId($category));
            $statement->bindValue('productId', $productId);
            $statement->execute();
        }
    }

    public function getProductId($productName)
    {
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT id from product where product_name = :productName;');
        $statement->bindValue('productName', $productName);
        $statement->execute();
        $id = $statement->fetch($db::FETCH_ASSOC);
        $productName = $id['id'];
        $productName = intval($productName);
        return $productName;

    }

    public function getProductFromCategory($categoryId) {

        $list = [];
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT product_id FROM `product_category` WHERE category_id = :category_id;');
        $statement->bindValue('category_id', $categoryId);
        $statement->execute();
        $productIds = $statement->fetchAll();
        foreach ($productIds as $productId) {
            $productId = intval($productId->product_id);
            array_push($list, $productId);
        }
        return $list;

    }


    public function getProduct($id) {

        $db = Database::getInstance();
        $statement= $db->prepare('SELECT * FROM product where id = :id and product_active = 1;');
        $statement->bindValue('id', $id);
        $statement->execute();
        $product = $statement->fetch();
        if (is_object($product)) {
            $product = new Product([
                'id' => $product->id,
                'product_name' => $product->product_name,
                'product_price' => floatval($product->product_price),
                'product_description' => $product->product_description,
                'product_picture'=> $product->product_picture,
                'product_active'=>intval($product->product_active),
            ]);
            $product->setData('quantity', 1);
        }
        return $product;
    }



    private function getCategoryId($category)
    {
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT id from category where category_name  = :categoryName ;');
        $statement->bindValue('categoryName',$category );
        $statement->execute();
        $id = $statement->fetch($db::FETCH_ASSOC);
        $categoryName = $id['id'];
        $categoryName = intval($categoryName);
        return $categoryName;
    }

    public function changeStatus($id,$status) {
        $db = Database::getInstance();
        $statement = $db->prepare('update product set product_active = :status WHERE id = :id;');
        $statement->bindValue('id',$id);
        $statement->bindValue('status',$status);
        $statement->execute();

    }

    public function getNewProducts() {
        $list = [];
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT * FROM `product` where product_active = 1 order by id DESC limit 3;');
        $statement->execute();
        $products = $statement->fetchAll();
        foreach ($products as $product) {
            array_push($list, $product);
        }
        return $list;

    }


}