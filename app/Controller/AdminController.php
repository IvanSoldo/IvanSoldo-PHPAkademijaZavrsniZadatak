<?php

namespace App\Controller;

use App\Core\Controller;

class AdminController extends Controller {

    public function indexAction() {
        $this->view('Home/index');
    }

    public function dashboardAction() {

        $this->view('Admin/dashboard');
    }

}