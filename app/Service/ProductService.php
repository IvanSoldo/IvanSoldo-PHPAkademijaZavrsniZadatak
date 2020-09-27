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



}