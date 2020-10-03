<?php

namespace App\Core;

class Controller {

    protected $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function view($view, $data =[]) {

        if (file_exists('../app/View/' . $view . '.phtml')) {
            require_once '../app/View/' . $view . '.phtml';
        }
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

}