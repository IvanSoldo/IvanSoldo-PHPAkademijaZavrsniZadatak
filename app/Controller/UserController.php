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
        parent::__construct();
        $this->userService = new UserService();
        $this->cartService = new CartService();
    }

    public function indexAction()
    {
        header('location: ' . URLROOT);
    }

    public function registerAction()
    {
        if ($this->auth->isLoggedIn()) {
            header('location: ' . URLROOT);
        }
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
        }
        if ($this->isGet()) {
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
        if ($this->auth->isLoggedIn()) {
            header('location: ' . URLROOT);
        }

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
        }
        if ($this->isGet()) {
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

    public function settingsAction()
    {
        if ($this->auth->isLoggedIn()) {
            $this->view('User/settings');
        } else {
            header('location: ' . URLROOT);
        }
    }

    public function shoppingCartAction()
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: ' . URLROOT);
        }

        if ($this->isPost()) {
            $data = [
                'totalPrice' => 0,
                'productId' => Request::getPostParam('id'),
                'productQuantity' => Request::getPostParam('quantity')
            ];
            $this->cartService->updateCart($data);
            if (isset($_POST['buy'])) {
                flash('register_success', 'Order submitted! Thank you!');
                $this->cartService->buy();
            }
            $this->view('User/shoppingCart', $data);
        }
        if ($this->isGet()) {
            $data = [
                'totalPrice' => 0,
                'productId' => '',
                'productQuantity' => ''
            ];
            if ($this->auth->isLoggedIn()) {
                $this->view('User/shoppingCart', $data);
            } else {
                header('location: ' . URLROOT);
            }
        }
    }

    public function checkoutAction()
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: ' . URLROOT);
        }

        if ($this->isPost()) {
            if (isset($_POST['buy'])) {
                $this->cartService->buy();
                flash('register_success', 'Order submitted! Thank you!');
                header('location: ' . URLROOT);
            }
        }
        if ($this->isGet()) {
            if (empty($_SESSION['cart'])) {
                header('location: ' . URLROOT);
            } else {
                $data = [
                    'totalPrice' => 0,
                    'customerInfo' => $this->cartService->customerInfo()
                ];
                $this->view('User/checkout', $data);
            }
        }
    }

    public function changePasswordAction()
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: ' . URLROOT);
        }
        if ($this->isPost()) {
            $data = [
                'password' => trim(Request::getPostParam('password')),
                'confirmPassword' => trim(Request::getPostParam('confirmPassword')),
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];
            $data = $this->userService->checkChangePasswordData($data);
            if ($this->userService->isChangePasswordDataValid($data)) {
                $this->userService->changePassword($data);
                flash('register_success', 'Password changed!');
                header('location: ' . URLROOT);
            } else {
                $this->view('User/changePassword', $data);
            }
        }
        if ($this->isGet()) {
            $data = [
                'password' => '',
                'confirmPassword' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            $this->view('User/changePassword', $data);
        }
    }

    public function changeAddressAction()
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: ' . URLROOT);
        }
        if ($this->isPost()) {
            $data = [
                'city' => trim(Request::getPostParam('city')),
                'postalCode' => trim(Request::getPostParam('postalCode')),
                'address' => trim(Request::getPostParam('address')),
                'cityError' => '',
                'postalCodeError' => '',
                'addressError' => ''
            ];
            $data = $this->userService->checkChangeAddress($data);
            if ($this->userService->isChangeAddressDataValid($data)) {
                $this->userService->changeAddress($data);
                flash('register_success', 'Address changed');
                header('location: ' . URLROOT);
            } else {
                $this->view('User/changeAddress', $data);
            }
        }
        if ($this->isGet()) {
            $data = [
                'city' => '',
                'postalCode' => '',
                'address' => '',
                'cityError' => '',
                'postalCodeError' => '',
                'addressError' => ''
            ];
            $this->view('User/changeAddress', $data);

        }
    }
}