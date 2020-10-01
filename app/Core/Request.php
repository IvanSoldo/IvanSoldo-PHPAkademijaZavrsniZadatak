<?php

namespace App\Core;

class Request
{
    public static function getPostParam($key, $default='')
    {
        return $_POST[$key] ?? htmlspecialchars($default, ENT_QUOTES, 'UTF-8');
    }

    public static function getPostParams()
    {
        return $_POST;
    }
}