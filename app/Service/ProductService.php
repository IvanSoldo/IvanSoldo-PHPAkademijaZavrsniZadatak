<?php

namespace App\Service;

use App\Repository\ProductRepository;

class ProductService {

    private $productRepository;

    public function __construct() {

        $this->productRepository = new ProductRepository();

    }

    public function getProducts() {
        return $this->productRepository->getProducts();
    }

    //returns array of products
    public function getProductsFromCategory($data) {
        $productList =[];
        $productIds = $this->productRepository->getProductFromCategory($data['id']);
        foreach ($productIds as $productId) {
            array_push($productList,$this->productRepository->getProduct($productId));
        }
        return $productList;

    }



}