<?php

namespace App\Core;

class Controller {

    public function model($model) { //TODO: U repository Core class

        require_once '..app/Model/' . $model . '.php';
        $className = "\\App\\Model\\" . $model . '()';
        return new $className;

    }

    public function view($view, $data =[]) {

        if (file_exists('../app/View/' . $view . '.phtml')) {
            require_once '../app/View/' . $view . '.phtml';
        } else {
            die('View does not exist'); //TODO: Redirect
        }

    }

}