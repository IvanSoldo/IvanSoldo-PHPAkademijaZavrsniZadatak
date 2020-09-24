<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{

    private $userRepository;


    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function checkRegisterData($data)
    {

        if (empty($data['email'])) {
            $data['emailError'] = 'Please enter email';
        } else {
            if ($this->userRepository->doesEmailExist($data['email'])) {
                $data['emailError'] = 'Email already in use.';
            }
        }

        if (empty($data['username'])) {
            $data['usernameError'] = 'Please enter username';
        } else {
            if ($this->userRepository->doesUsernameExist($data['username'])) {
                $data['usernameError'] = 'Username already in use';
            }
        }

        if (empty($data['firstName'])) {
            $data['firstNameError'] = 'Please enter first name';
        }

        if (empty($data['lastName'])) {
            $data['lastNameError'] = 'Please enter last name';
        }

        if (empty($data['password'])) {
            $data['passwordError'] = 'Please enter password';
        } else {
            if (strlen($data['password']) < 6) {
                $data['passwordError'] = 'Password must be at least 6 characters';
            }
        }

        if (empty($data['confirmPassword'])) {
            $data['confirmPasswordError'] = 'Please confirm your password';
        } else {
            if ($data['password'] != $data['confirmPassword']) {
                $data['confirmPasswordError'] = 'Password do not match';
                }
        }

        if (empty($data['city'])) {
            $data['cityError'] = 'Please enter city';
        }

        if (empty($data['postalCode'])) {
            $data['postalCodeError'] = 'Please enter postalCode';
        } else {
            if (strlen($data['postalCode']) != 5 ) {
                $data['postalCodeError'] = 'Please enter valid postal code';
            }
        }

        if (empty($data['address'])) {
            $data['addressError'] = 'Please enter address';
        }

        return $data;

    }

    public function isRegisterDataValid($data) {

        if (empty($data['emailError']) && empty($data['usernameError']) && empty($data['firstNameError']) && empty($data['lastNameError'])
            &&empty($data['passwordError']) &&empty($data['confirmPasswordError']) &&empty($data['cityError']) &&empty($data['postalCodeError'])
            &&empty($data['addressError']) ) {
            return true;
        }
        return false;
    }





}