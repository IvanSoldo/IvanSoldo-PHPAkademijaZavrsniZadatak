<?php

namespace App\Controller;

use App\Core\Controller;
use App\Service\ProductService;


//TODO: add htmlspeacialchars to input fields/textarea/limit text length


class HomeController extends Controller{

    private $productService;

    public function __construct() {
        $this->productService = new ProductService();
    }

    public function indexAction() {

        $data = $this->productService->getProducts();

        $this->view('Home/index', $data);
    }

    public function aboutAction() {
        $this->view('Home/about');
    }

    public function contactAction() {
        $this->view('Home/contact');
    }


}