<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService {

    private $userRepository;


    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function register() {



    }


}