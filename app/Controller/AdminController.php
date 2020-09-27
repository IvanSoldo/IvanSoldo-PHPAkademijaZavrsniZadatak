<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Service\AdminService;
use App\Service\UserService;

class AdminController extends Controller
{

    private $userService;
    private $adminService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->adminService = new AdminService();

    }

    public function indexAction()
    {
        if(!array_key_exists('role', $_SESSION)) {//TODO: refactor to method
            $this->view('Home/index');
        } else if ($_SESSION['role'] != 'admin') {
            $this->view('Home/index');
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
                $this->view('Home/index');

            } else if ($_SESSION['role'] != 'admin') {
                $this->view('Home/index');
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
                'productImage'=> $_FILES['productImage'],
                'chosenCategories' => $categories,
                'categoryArr' =>$this->adminService->getCategories(),
                'productNameError'=> '',
                'productPriceError'=> '',
                'productCategoryError'=> '',
                'productImageError'=>'',
            ];

            $data = $this->adminService->checkProductData($data);
            $this->view('Admin/manageProducts', $data);


        } else {
            $data = [
                'productName'=> '',
                'productPrice'=> '',
                'productDescription'=>'',
                'productImage'=>'',
                'categoryArr' =>$this->adminService->getCategories(),
                'productNameError'=> '',
                'productPriceError'=> '',
                'productCategoryError'=> '',
                'productImageError'=>''
            ];


            if(!array_key_exists('role', $_SESSION)) {
                $this->view('Home/index');

            } else if ($_SESSION['role'] != 'admin') {
                $this->view('Home/index');
            } else {
                $this->view('Admin/manageProducts', $data);
            }
        }

    }

}