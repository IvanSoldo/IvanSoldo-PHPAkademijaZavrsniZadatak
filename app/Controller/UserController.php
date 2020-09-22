<?php

namespace App\Controller;

use App\Core\Controller;

class UserController extends Controller{

    public function registerAction() {
        $this->view('User/register');
    }

    public function loginAction() {
        $this->view('User/login');
    }

    public function registerSubmitAction() {
        $this->view('Home/index');
    }

}