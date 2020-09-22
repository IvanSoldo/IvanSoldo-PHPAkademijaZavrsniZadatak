<?php

namespace App\Controller;

use App\Core\Controller;

//TODO: add htmlspeacialchars to input fields/textarea

class HomeController extends Controller{

    public function indexAction() {

        $this->view('Home/index');

    }

    public function aboutAction() {
        $this->view('Home/about');
    }

    public function contactAction() {
        $this->view('Home/contact');
    }


}