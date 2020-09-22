<?php

namespace App\Core;

class Controller {

    public function view($view, $data =[]) {

        if (file_exists('../app/View/' . $view . '.phtml')) {
            require_once '../app/View/' . $view . '.phtml';
        } else {
            die('View does not exist'); //TODO: Redirect
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