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

    private function changeQuantityOfProduct($data) {

        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            $product = unserialize($_SESSION['cart'][$i]);
            if ($product->getData('id') == $data['productId']) {
                $product->setData('quantity', $data['productQuantity']);
                $_SESSION['cart'][$i] = serialize($product);
            }
        }

    }

    private function deleteProductFromCart($data) {
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            $product = unserialize($_SESSION['cart'][$i]);
            if ($product->getData('id') == $data['productId']) {
                unset($_SESSION['cart'][$i]);
            }
        }

    }

    public function updateCart($data) {
        (isset($_POST['changeQuantity'])) ? $this->changeQuantityOfProduct($data) : $this->deleteProductFromCart($data);

    }


}