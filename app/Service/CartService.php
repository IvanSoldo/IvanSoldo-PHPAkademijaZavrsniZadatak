<?php

namespace App\Service;



class CartService {



    public function __construct() {

    }

    public function addToCart() {

        if(!empty($_GET['id'])) {
            array_push($_SESSION['cart'], $_GET['id']);
        }

    }

}