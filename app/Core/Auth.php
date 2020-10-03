<?php

namespace App\Core;

class Auth {

    public function isLoggedIn() {
        return array_key_exists('role', $_SESSION);
    }

    public function isAdmin() {
        if ($_SESSION['role'] != 'admin') {
            return false;
        }
        return true;
    }



}