<?php

namespace App\Controller;

use App\Core\Controller;

use App\Service\AdminService;
use App\Service\CartService;
use App\Service\ProductService;


class HomeController extends Controller{

    //TODO:Sanitize string before post method

    private $productService;
    private $adminService;
    private $cartService;

    public function __construct() {
        $this->productService = new ProductService();
        $this->adminService = new AdminService();
        $this->cartService = new CartService();
    }

    public function indexAction() {

        $this->cartService->getProductId();
        $data = $this->productService->getFilteredProducts();

        $this->view('Home/index', $data);
    }

    public function aboutAction() {
        $this->view('Home/about');
    }

    public function contactAction() {
        $this->view('Home/contact');
    }

    public function diningRoomAction() {

        $this->cartService->getProductId();

        $data['id'] = 1;
        $data = $this->productService->getProductsFromCategory($data);
        $this->view('Home/diningRoom', $data);
    }

    public function gardenAction() {

        $this->cartService->getProductId();

        $data['id'] = 2;
        $data = $this->productService->getProductsFromCategory($data);
        $this->view('Home/garden', $data);
    }

    public function livingRoomAction() {

        $this->cartService->getProductId();

        $data['id'] = 3;
        $data = $this->productService->getProductsFromCategory($data);
        $this->view('Home/livingRoom', $data);
    }





}