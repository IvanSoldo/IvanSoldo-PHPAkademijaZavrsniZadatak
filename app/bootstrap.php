<?php

require_once  'Util/utilities.php';

//Autoload Core

spl_autoload_register(function ($className) {
    $filename = str_replace('\\', '/', $className) . '.php';
    $filename = explode('/', $filename);
    unset($filename[0]);
    $filename = implode('/', $filename);
    require $filename;
});




