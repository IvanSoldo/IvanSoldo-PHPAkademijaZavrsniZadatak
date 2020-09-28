<?php

namespace App\Controller;

use App\Core\Controller;
use App\Service\CartService;
use App\Service\UserService;
use App\Core\Request;

class UserController extends Controller
{

    private $userService;
    private $cartService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->cartService = new CartService();

    }

    public function indexAction()
    {
        header('location: ' . URLROOT);
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

            if (array_key_exists('role', $_SESSION)) {
                header('location: ' . URLROOT);

            } else {
                $this->view('User/register', $data);
            }

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
                header('location: ' . URLROOT);
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

            if (array_key_exists('role', $_SESSION)) {
                header('location: ' . URLROOT);

            } else {
                $this->view('User/login', $data);
            }


        }

    }

    public function logoutAction()
    {
        $this->userService->logout();
    }

    public function settingsAction()
    {
        if ($this->isPost()) {
            $data = [
                'password' => trim(Request::getPostParam('password')),
                'confirmPassword' => trim(Request::getPostParam('confirmPassword')),
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            $data = $this->userService->checkSettingsData($data);
            if ($this->userService->isSettingsDataValid($data)) {
                $this->userService->changePassword($data);
                flash('register_success', 'Password changed!');
                header('location: ' . URLROOT . '/User/settings');
            } else {
                $this->view('User/settings', $data);
            }

        } else {

            $data = [
                'password' => '',
                'confirmPassword' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];
            if (!array_key_exists('role', $_SESSION)) {
                header('location: ' . URLROOT);

            } else {
                $this->view('User/settings', $data);
            }
        }
    }

    public function shoppingCartAction()
    {

        if ($this->isPost()) {
            $data = [
                'totalPrice' => 0,
                'productId' => Request::getPostParam('id'),
                'productQuantity' => Request::getPostParam('quantity')
            ];

            /*
            for ($i = 0; $i < count($_SESSION['cart']); $i++) {
                $product = unserialize($_SESSION['cart'][$i]);
                if ($product->getData('id') == $data['productId']) {
                    $product->setData('quantity', $data['productQuantity']);
                    $product->setdata('quantity', $product->getData('quantity'));
                    $_SESSION['cart'][$i] = serialize($product); //TODO:same method with unset to delete from cart.
                }
            } */

            $this->view('User/shoppingCart', $data);

        } else {

            $data = [
                'totalPrice' => 0,
                'productId' => '',
                'productQuantity' => ''
            ];

            if (!array_key_exists('role', $_SESSION)) {
                header('location: ' . URLROOT);
            } else {
                $this->view('User/shoppingCart', $data);
            }
        }

    }


}