<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Service\UserService;

class AdminController extends Controller
{

    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();

    }

    public function indexAction()
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

}