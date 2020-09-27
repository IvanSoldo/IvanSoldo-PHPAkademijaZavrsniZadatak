<?php

namespace App\Controller;

use App\Core\Controller;

use App\Service\AdminService;
use App\Service\ProductService;


//TODO: add htmlspeacialchars to input fields/textarea/limit text length


class HomeController extends Controller{

    private $productService;
    private $adminService;

    public function __construct() {
        $this->productService = new ProductService();
        $this->adminService = new AdminService();
    }

    public function indexAction() {

       /* $data['id'] = 2;
        $test = $this->productService->getProductsFromCategory($data);
        var_dump($test); */

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