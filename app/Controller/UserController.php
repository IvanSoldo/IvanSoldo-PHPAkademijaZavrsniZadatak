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

    public function registerAction()
    {
        if ($this->isPost()) {
            $data= [
                'email' => trim(Request::getPostParam('email')),
                'username' =>trim(Request::getPostParam('username')),
                'firstName' =>trim(Request::getPostParam('firstName')),
                'lastName' =>trim(Request::getPostParam('email')),
                'password'=>trim(Request::getPostParam('password')),
                'confirmPassword'=>trim(Request::getPostParam('confirmPassword')),
                'city'=>trim(Request::getPostParam('city')),
                'postalCode'=>trim(Request::getPostParam('postalCode')),
                'address'=>trim(Request::getPostParam('address')),
                'emailError' => '',
                'usernameError' =>'',
                'firstNameError' =>'',
                'lastNameError' =>'',
                'passwordError'=>'',
                'confirmPasswordError'=>'',
                'cityError'=>'',
                'postalCodeError'=>'',
                'addressError'=>''
            ];

            $data = $this->userService->checkRegisterData($data);
            if ($this->userService->isRegisterDataValid($data)) {
                $this->view('User/login',$data);
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


        } else {
            $data = [
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];


            $this->view('User/login',$data);
        }


    }
}