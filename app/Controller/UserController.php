<?php

namespace App\Controller;

use App\Core\Controller;
use App\Service\UserService;
use App\Core\Request;

class UserController extends Controller{

    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function registerAction() {
        $this->view('User/register');
    }

    public function registerSubmitAction() {
        $this->view('User/register');
    }

    public function loginAction() {
        $this->view('User/login');
    }








}