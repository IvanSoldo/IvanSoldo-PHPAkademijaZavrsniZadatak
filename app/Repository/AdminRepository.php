<?php

namespace App\Repository;

use App\Core\Database;

class AdminRepository {

    public function __construct() {

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






    /*public function getCategories() {
        $list = [];
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT `category_name` FROM `category`');
        $statement->execute();
        $categories = $statement->fetchAll();
        foreach ($categories as $category) {
          array_push($list, $category->category_name);
        }
        return $list;
    } */


}