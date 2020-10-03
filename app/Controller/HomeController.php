<?php

namespace App\Controller;

use App\Core\Controller;
use App\Service\CartService;
use App\Service\ProductService;


class HomeController extends Controller{

    private $productService;
    private $cartService;

    public function __construct() {
        $this->productService = new ProductService();
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

    public function newProductsAction() {

        $this->cartService->getProductId();

        $data = $this->productService->getNewProducts();

        $this->view('Home/newProducts', $data);

    }

    public function productPageAction($id){

        $product = $this->productService->getSingleProduct($id);
        $data = [
          'product'=>$product
        ];

        $this->cartService->getProductId();

        $this->view('Home/productPage',$data);
    }


}