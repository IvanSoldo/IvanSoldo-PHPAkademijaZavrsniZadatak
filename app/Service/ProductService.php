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

    public function getSingleProduct($id, $productName='') {

        if ($id == 0) {
            if (isset($_POST['searchBar'])) {
                $productName = $_POST['searchBar'];
            }

            if ($this->productRepository->doesProductExist($productName)) {
                $id = $this->productRepository->getProductId($productName);
                return $this->productRepository->getProduct($id);
            }
        }

        if (!$this->productRepository->checkIfProductExistById($id)) {
            header('location: ' . URLROOT);
        } else {
            return $this->productRepository->getProduct($id);
        }
    }

    public function getNewProducts() {
        return $this->productRepository->getNewProducts();
    }





}