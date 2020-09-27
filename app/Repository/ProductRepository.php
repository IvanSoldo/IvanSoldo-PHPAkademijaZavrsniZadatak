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

    private function getProductId($productName)
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

    public function getProduct($productName) {

        $db = Database::getInstance();
        $statement= $db->prepare('SELECT * FROM product where product_name = :productName;');
        $statement->bindValue('productName', $productName);
        $statement->execute();
        $product = $statement->fetch();
        $product = new Product([
            'id' => $product->id,
            'product_name' => $product->product_name,
            'product_price' => floatval($product->product_price),
            'product_description' => $product->product_description,
            'product_picture'=> $product->product_picture,
            'product_active'=>$product->product_active
        ]);

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


}