<?php

namespace App\Controller;

use App\Core\Controller;

use App\Service\AdminService;
use App\Service\CartService;
use App\Service\ProductService;


//TODO: add htmlspeacialchars to input fields/textarea/limit text length
//TODO: Redirect to static page not found


class HomeController extends Controller{

    private $productService;
    private $adminService;
    private $cartService;

    public function __construct() {
        $this->productService = new ProductService();
        $this->adminService = new AdminService();
        $this->cartService = new CartService();
    }

    public function indexAction() {

        $this->cartService->addToCart();

        $data = $this->productService->getProducts();

        $this->view('Home/index', $data);
    }

    public function aboutAction() {
        $this->view('Home/about');
    }

    public function contactAction() {
        $this->view('Home/contact');
    }

    public function diningRoomAction() {

        $data['id'] = 2;
        $data = $this->productService->getProductsFromCategory($data);
        $this->view('Home/diningRoom', $data);
    }

    public function gardenAction() {

        $data['id'] = 3;
        $data = $this->productService->getProductsFromCategory($data);
        $this->view('Home/garden', $data);
    }

    public function livingRoomAction() {

        $data['id'] = 1;
        $data = $this->productService->getProductsFromCategory($data);
        $this->view('Home/livingRoom', $data);
    }





}