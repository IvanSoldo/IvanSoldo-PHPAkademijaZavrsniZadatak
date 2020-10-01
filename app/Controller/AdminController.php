<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Service\AdminService;
use App\Service\ProductService;
use App\Service\UserService;

class AdminController extends Controller
{

    private $userService;
    private $adminService;
    private $productService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->adminService = new AdminService();
        $this->productService = new ProductService();

    }

    public function indexAction()
    {

        if(!array_key_exists('role', $_SESSION)) {//TODO: refactor to method
            header('location: ' . URLROOT);
        } else if ($_SESSION['role'] != 'admin') {
            header('location: ' . URLROOT);
        } else {
            $this->view('Admin/index');
        }

    }

    public function addAdminAction()
    {

        if ($this->isPost()) {
            $data = [
                'email' => trim(Request::getPostParam('email')),
                'username' => trim(Request::getPostParam('username')),
                'firstName' => trim(Request::getPostParam('firstName')),
                'lastName' => trim(Request::getPostParam('lastName')),
                'password' => trim(Request::getPostParam('password')),
                'confirmPassword' => trim(Request::getPostParam('confirmPassword')),
                'city' => trim(Request::getPostParam('city')),
                'postalCode' => trim(Request::getPostParam('postalCode')),
                'address' => trim(Request::getPostParam('address')),
                'emailError' => '',
                'usernameError' => '',
                'firstNameError' => '',
                'lastNameError' => '',
                'passwordError' => '',
                'confirmPasswordError' => '',
                'cityError' => '',
                'postalCodeError' => '',
                'addressError' => ''
            ];

            $data = $this->userService->checkRegisterData($data);
            if ($this->userService->isRegisterDataValid($data)) {
                $this->userService->addAdmin($data);
                flash('register_success', 'New Admin added!');
                $this->view('Admin/index');
            } else {
                $this->view('Admin/addAdmin', $data);
            }

        } else {
            $data = [
                'email' => '',
                'username' => '',
                'firstName' => '',
                'lastName' => '',
                'password' => '',
                'confirmPassword' => '',
                'city' => '',
                'postalCode' => '',
                'address' => '',
                'emailError' => '',
                'usernameError' => '',
                'firstNameError' => '',
                'lastNameError' => '',
                'passwordError' => '',
                'confirmPasswordError' => '',
                'cityError' => '',
                'postalCodeError' => '',
                'addressError' => ''
            ];

            if(!array_key_exists('role', $_SESSION)) {
                header('location: ' . URLROOT);

            } else if ($_SESSION['role'] != 'admin') {
                header('location: ' . URLROOT);
            } else {
                $this->view('Admin/addAdmin',$data);
            }
        }
    }

    public function manageProductsAction() {

        if ($this->isPost()) {

            $categories = '';
            $categories = $this->adminService->isRadioButtonSet($categories);

            $data = [
                'productName'=> trim(Request::getPostParam('productName')),
                'productPrice'=> trim(Request::getPostParam('productPrice')),
                'productDescription'=>trim(Request::getPostParam('productDescription')),
                'productImageSize'=>$_FILES['productImage']['size'],
                'productImageBlob' =>$_FILES['productImage']['tmp_name'],
                'productImageErr' =>$_FILES['productImage']['error'],
                'chosenCategories' => $categories,
                'categoryArr' =>$this->adminService->getCategories(),
                'productNameError'=> '',
                'productPriceError'=> '',
                'productCategoryError'=> '',
                'productImageError'=>'',
                'productsArray'=>$this->productService->getProducts(),
            ];

            $data = $this->adminService->checkProductData($data);
            if ($this->adminService->isProductDataValid($data)) {
                $this->adminService->addProduct($data);
                flash('register_success', 'New Product added!');
                $this->view('Admin/manageProducts', $data);
            } else {
                $this->view('Admin/manageProducts', $data);
            }



        } else {

            $data = [
                'productName'=> '',
                'productPrice'=> '',
                'productDescription'=>'',
                'chosenCategories' =>'',
                'categoryArr' =>$this->adminService->getCategories(),
                'productNameError'=> '',
                'productPriceError'=> '',
                'productCategoryError'=> '',
                'productImageError'=>'',
                'productsArray'=>$this->productService->getProducts()
            ];

            if (!empty($_GET['id'])) {
                $id = $_GET['id'];
                $this->adminService->changeProductStatus($data['productsArray'], $id);
                header('location: ' . URLROOT.'/Admin/manageProducts');
            }

            if(!array_key_exists('role', $_SESSION)) {
                header('location: ' . URLROOT);

            } else if ($_SESSION['role'] != 'admin') {
                header('location: ' . URLROOT);
            } else {
                $this->view('Admin/manageProducts', $data);
            }
        }

    }

    public function ordersAction() {

        if ($this->isPost()) {

            $this->adminService->printAllOrders();

        } else {

            if(!array_key_exists('role', $_SESSION)) {
                header('location: ' . URLROOT);

            } else if ($_SESSION['role'] != 'admin') {
                header('location: ' . URLROOT);
            } else {

                $data = $this->adminService->getAllOrders();
                $this->view('Admin/orders', $data);
            }
        }


    }

}