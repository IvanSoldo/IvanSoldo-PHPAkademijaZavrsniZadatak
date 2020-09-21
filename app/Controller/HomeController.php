<?php

namespace App\Controller;

use App\Core\Controller;

class HomeController extends Controller{

    public function __construct() {

    }

    public function indexAction() {
        $data = ['title' => 'Welcome'];
        $this->view('Home/index', $data);

    }

    public function aboutAction() {
        $this->view('Home/about');
    }


}