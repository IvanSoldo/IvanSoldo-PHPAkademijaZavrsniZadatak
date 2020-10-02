<?php

namespace App\Core;

class Request
{
    public static function getPostParam($key, $default='')
    {
        return $_POST[$key] ?? $default;
    }

    public static function getPostParams()
    {
        return $_POST;
    }
}