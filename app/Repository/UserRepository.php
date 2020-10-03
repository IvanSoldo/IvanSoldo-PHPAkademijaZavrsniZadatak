<?php

namespace App\Repository;

use App\Model\User;
use App\Core\Database;

class UserRepository {

    private $user;

    public function __construct() {
        $this->user = new User();
    }


    public function doesEmailExist($email)
    {

        $db = Database::getInstance();
        $statement = $db->prepare('select id from user where email = (?)', [$email]);
        $statement->execute([$email]);
        $fetched = $statement->rowCount();
        return (bool)$fetched;

    }

    public function doesUsernameExist($username)
    {

        $db = Database::getInstance();
        $statement = $db->prepare('select id from user where username = (?)', [$username]);
        $statement->execute([$username]);
        $fetched = $statement->rowCount();
        return (bool)$fetched;

    }

    public function insertAddress($data) {

        $db = Database::getInstance();
        $statement = $db->prepare('insert into address (city_name,postal_code,address) values (:city,:postalCode,:address);');
        $statement->bindValue('city', $data['city']);
        $statement->bindValue('postalCode', $data['postalCode']);
        $statement->bindValue('address', $data['address']);
        $statement->execute();

    }

    private function getAddressId($data) {
        $db = Database::getInstance();
        $statement = $db->prepare('SELECT id from address where city_name = :city && postal_code = :postalCode && address = :address ORDER BY ID DESC limit 1;');
        $statement->bindValue('city', $data['city']);
        $statement->bindValue('postalCode', $data['postalCode']);
        $statement->bindValue('address',$data['address']);
        $statement->execute();
        $id = $statement->fetch($db::FETCH_ASSOC);
        $addressId = $id['id'];
        $addressId = intval($addressId);
        return $addressId ;


    }

    public function insertUser($data) {
        $db=Database::getInstance();
        $statement = $db->prepare('insert into user (email,username,first_name,last_name,password,address_id,role_id)
                                    values (:email, :username, :firstName, :lastName, :password,:addressId,:role_id);');
        $statement->bindValue('email', $data['email']);
        $statement->bindValue('username', $data['username']);
        $statement->bindValue('firstName', $data['firstName']);
        $statement->bindValue('lastName', $data['lastName']);
        $statement->bindValue('password', $data['password']);
        $statement->bindValue('addressId', $this->getAddressId($data));
        $statement->bindValue('role_id', $data['role']);
        $statement->execute();

    }

    public function getUserByUsername($username)
    {
        $user ='';
        $db = Database::getInstance();
        $statement = $db->prepare('select u.id, u.email, u.username, u.first_name, u.last_name, u.password, 
            a.city_name as city, a.postal_code as postalCode, a.address as address, r.name as role
            from user u
            inner join address a on u.address_id = a.id
            inner join role r on u.role_id = r.id
            where u.username = (?)', [$username]);

        $statement->execute([$username]);

        $user = $statement->fetch();
        $user = new User([
                'id'=>$user->id,
                'email' => $user->email,
                'username' => $user->username,
                'firstname' => $user->first_name,
                'lastname' => $user->last_name,
                'password'=> $user->password,
                'city'=>$user->city,
                'postalCode'=>$user->postalCode,
                'address'=>$user->address,
                'role'=>$user->role
            ]);

        return $user;
    }



    public function updatePassword($password, $username) {

        $db = Database::getInstance();
        $statement = $db->prepare('UPDATE user SET password=:password WHERE username=:username;');
        $statement->bindValue('password', $password);
        $statement->bindValue('username',$username);
        $statement->execute();

    }


    public function updateAddress($data) {
        $db = Database::getInstance();
        $statement = $db->prepare("update address set city_name = :city_name, postal_code= :postal_code, address = :address  where id =
                                            (SELECT id FROM (select a.id from address a inner join user u on u.address_id = a.id where u.id = :id)
                                            AS aid);");
        $statement->bindValue('city_name', $data['city']);
        $statement->bindValue('postal_code', $data['postalCode']);
        $statement->bindValue('address', $data['address']);
        $statement->bindValue('id', $_SESSION['userId']);
        $statement->execute();
    }

}