<?php

namespace App\Service;

use App\Model\User;
use App\Repository\UserRepository;

class UserService
{

    private $userRepository;
    private $user;


    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->user = new User();
    }

    public function checkRegisterData($data)
    {

        //TODO: change if empty check into 1 private dynamic method.
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
            if (strlen($data['postalCode']) != 5) {
                $data['postalCodeError'] = 'Please enter valid postal code';
            }
        }

        if (empty($data['address'])) {
            $data['addressError'] = 'Please enter address';
        }

        return $data;

    }

    public function isRegisterDataValid($data)
    {

        if (empty($data['emailError']) && empty($data['usernameError']) && empty($data['firstNameError']) && empty($data['lastNameError'])
            && empty($data['passwordError']) && empty($data['confirmPasswordError']) && empty($data['cityError']) && empty($data['postalCodeError'])
            && empty($data['addressError'])) {
            return true;
        }
        return false;
    }

    public function register($data)
    {
        $data['role'] = 3;
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->userRepository->insertAddress($data);
        $this->userRepository->insertUser($data);
    }

    public function checkLoginData($data)
    {

        if ($this->userRepository->doesUsernameExist($data['username'])) {
            $this->user = $this->userRepository->getUserByUsername($data['username']);
        } else {
            $data['usernameError'] = 'Invalid username or password';
            $data['passwordError'] = 'Invalid username or password';
        }

        if (!password_verify($data['password'], $this->user->getData('password'))) {
            $data['usernameError'] = 'Invalid username or password';
            $data['passwordError'] = 'Invalid username or password';
        }

        return $data;
    }

    public function isLoginDataValid($data)
    {
        if (empty($data['usernameError']) && empty($data['passwordError'])) {
            $this->createUserSession($this->user);
            return true;
        }
        return false;

    }

    private function createUserSession($user)
    {
        $_SESSION['username'] = $user->getData('username');
        $_SESSION['role'] = $user->getData('role');
    }

    public function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        session_destroy();
        header('location: ' . URLROOT . '/User/login');
    }

    public function checkSettingsData($data) {

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
        return $data;
    }

    public function isSettingsDataValid($data) { //TODO: password must be 6 length
        if (empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
            return true;
        }
        return false;
    }

    public function changePassword($data) {

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->userRepository->updatePassword($data['password'], $_SESSION['username']);

    }

    public function addAdmin($data)
    {
        $data['role'] = 1;
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->userRepository->insertAddress($data);
        $this->userRepository->insertUser($data);
    }


}