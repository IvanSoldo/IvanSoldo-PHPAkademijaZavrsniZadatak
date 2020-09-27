<?php

namespace App\Repository;

use App\Core\Database;
use App\Model\Product;

class ProductRepository {

    private $product;

    public function __construct() {

        $this->product = new Product();
    }

    public function doesProductCategoryExist($category)
    {
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT `category_name` FROM `category` where `category_name` = (?)', [$category]);
        $statement->execute([$category]);
        $fetched = $statement->rowCount();
        return (bool)$fetched;
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

    public function insertProduct($data) {
        $db=Database::getInstance();
        $statement = $db->prepare('insert into product (product_name, product_price, product_description, product_picture)
                                            values (:productName, :productPrice, :productDescription, :productPicture);');
        $statement->bindValue('productName', $data['productName']);
        $statement->bindValue('productPrice', $data['productPrice']);
        $statement->bindValue('productDescription', $data['productDescription']);
        $statement->bindValue('productPicture', file_get_contents($data['productImageBlob']));
        $statement->execute();
    }

    


}