<?php

namespace App\Service;


use App\Repository\ProductRepository;

class CartService
{

    private $productRepository;

    public function __construct()
    {

        $this->productRepository = new ProductRepository();

    }

    public function getProductId()
    {

        if (!empty($_GET['id'])) {
            if (is_numeric($_GET['id'])) {
                if ($this->productRepository->checkIfProductExistById($_GET['id'])) {
                    $product = $this->productRepository->getProduct(intval($_GET['id']));
                    array_push($_SESSION['cart'], serialize($product));
                    $_SESSION['cart'] = array_unique($_SESSION['cart']);
                }
            }
        }
    }


}