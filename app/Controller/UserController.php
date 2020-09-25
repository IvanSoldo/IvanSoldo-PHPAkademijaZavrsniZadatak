<?php

namespace App\Controller;

use App\Core\Controller;
use App\Service\UserService;
use App\Core\Request;

class UserController extends Controller
{

    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();

    }

    public function indexAction() {
        $this->view('Home/index');
    }

    public function registerAction()
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
                $this->userService->register($data);
                flash('register_success', 'You are now registered and can log in!');
                header('location: ' . URLROOT . '/User/login');
            } else {
                $this->view('User/register', $data);
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

            $this->view('User/register', $data);
        }

    }


    public function loginAction()
    {

        if ($this->isPost()) {
            $data = [
                'username' => trim(Request::getPostParam('username')),
                'password' => trim(Request::getPostParam('password')),
                'usernameError' => '',
                'passwordError' => ''
            ];

            $data = $this->userService->checkLoginData($data);
            if ($this->userService->isLoginDataValid($data)) {
                flash('register_success', 'Welcome ' . $_SESSION['username'] . ' !');
                header('location: ' . URLROOT . '/Home/index');
            } else {
                $this->view('User/login', $data);
            }

        } else {
            $data = [
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];


            $this->view('User/login', $data);
        }

    }

    public function logoutAction()
    {
        $this->userService->logout();
    }

    public function settingsAction() {
        if ($this->isPost()) {
            $data = [
                'password' => trim(Request::getPostParam('password')),
                'confirmPassword' => trim(Request::getPostParam('confirmPassword')),
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            $data = $this->userService->checkSettingsData($data);
            if($this->userService->isSettingsDataValid($data)) {
                $this->userService->changePassword($data);
                flash('register_success', 'Password changed!');
                header('location: ' . URLROOT . '/User/settings');
            } else {
                $this->view('User/settings',$data);
            }

        } else {

            $data = [
                'password' => '',
                'confirmPassword' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            $this->view('User/settings', $data);
        }

    }


}