<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Repository\AdminRepository;
use App\Service\AdminService;
use App\Service\UserService;

class AdminController extends Controller
{

    private $userService;
    private $adminService;
    private $adminRepo;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->adminService = new AdminService();
        $this->adminRepo = new AdminRepository();

    }

    public function indexAction() //TODO: refactor to method
    {
        if(!array_key_exists('role', $_SESSION)) {
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


            //TODO:Pun in service
            $categories = '';
            if (isset($_POST['categories'])) {
                $categories = $_POST['categories'];
            }

            $data = [
                'productName'=> trim(Request::getPostParam('productName')),
                'productPrice'=> trim(Request::getPostParam('productPrice')),
                'productDescription'=>trim(Request::getPostParam('productDescription')),
                'productImage'=> $_FILES['productImage'],
                'chosenCategories' => $categories,
                'categoryArr' =>$this->adminRepo->getCategories(),
                'productNameError'=> '',
                'productPriceError'=> '',
                'productCategoryError'=> '',
                'productImageError'=>''
            ];

            var_dump($data['chosenCategories']);
            $data = $this->adminService->checkProductData($data);

            if(!array_key_exists('role', $_SESSION)) {
                $this->view('Home/index');

            } else if ($_SESSION['role'] != 'admin') {
                $this->view('Home/index');
            } else {
                $this->view('Admin/manageProducts', $data);
            }

        } else {
            $data = [
                'productName'=> '',
                'productPrice'=> '',
                'productDescription'=>'',
                'productImage'=>'',
                'categoryArr' =>$this->adminRepo->getCategories(),
                'productNameError'=> '',
                'productPriceError'=> '',
                'productCategoryError'=> '',
                'productImageError'=>''
            ];

            $this->view('Admin/manageProducts', $data);
        }





    }

}