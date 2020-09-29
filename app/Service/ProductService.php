<?php

namespace App\Service;

use App\Repository\ProductRepository;

class ProductService {

    private $productRepository;

    public function __construct() {
        $this->productRepository = new ProductRepository();

    }

    public function getFilteredProducts() {
        return $this->productRepository->getFilteredProducts();
    }

    //returns array of products
    public function getProductsFromCategory($data) {
        $productList =[];
        $productIds = $this->productRepository->getProductFromCategory($data['id']);
        foreach ($productIds as $productId) {
            array_push($productList,$this->productRepository->getProduct($productId));
            $productList = array_values($productList);
            for ($i=0; $i<count($productList); $i++) {
                if (!is_object($productList[$i])) {
                    unset($productList[$i]);

                }
            }
        }

        return $productList;

    }

    public function getProducts() {
        return $this->productRepository->getProducts();
    }



}