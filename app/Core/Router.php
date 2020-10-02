<?php

namespace App\Core;

class Router {

    protected $currentController = 'Home';
    protected $currentMethod = 'indexAction';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();
        if (file_exists('../app/Controller/' . ucwords($url[0]) . 'Controller.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        require_once '../app/Controller/' . $this->currentController . 'Controller.php';
        $className = CN . $this->currentController . 'Controller';
        $this->currentController = new $className;

        if (isset($url[1])) { //TODO: Catch router exception
            if (method_exists($this->currentController, $url[1] . 'Action')) {
                $this->currentMethod = $url[1] . 'Action';
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod],$this->params );

    }

    private function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/'); //remove last / if exists
            $url = filter_var($url, FILTER_SANITIZE_URL); // making sure nothing is there an url wouldn't have
            $url = explode('/', $url);
            return $url;
        }
    }


}
