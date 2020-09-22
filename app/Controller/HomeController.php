<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Database;


class HomeController extends Controller{

    public function indexAction() {
        $this->view('Home/index');
        $db = Database::getInstance();
    }

    public function aboutAction() {
        $this->view('Home/about');
    }


}