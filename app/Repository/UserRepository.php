<?php

namespace App\Repository;

use App\Model\User;
use App\Core\Database;

class UserRepository
{


    public function doesEmailExist($email)
    {

        $db = Database::getInstance();
        $statement = $db->prepare('select id from user where email = (?)', [$email]);
        $statement->execute([
            $email
        ]);
        $fetched = $statement->rowCount();
        return (bool)$fetched;

    }

    public function doesUsernameExist($username)
    {

        $db = Database::getInstance();
        $statement = $db->prepare('select id from user where username = (?)', [$username]);
        $statement->execute([
            $username
        ]);
        $fetched = $statement->rowCount();
        return (bool)$fetched;

    }

    public function doesCountryExist($country)
    {

        $db = Database::getInstance();
        $statement = $db->prepare('select name from country where name = (?)', [$country]);
        $statement->execute([
            $country
        ]);
        $fetched = $statement->rowCount();
        return (bool)$fetched;

    }



    public function getUserByUsername($username)
    {
        $newUser ='';
        $db = Database::getInstance();
        $statement = $db->prepare('select u.email, u.username, u.first_name, u.last_name, u.password, 
            c.name as country, a.city_name as city, a.postal_code as postalCode, a.address as address, r.name as role
            from user u
            inner join address a on u.address_id = a.id
            inner join country c on a.country_code = c.code
            inner join role r on u.role_id = r.id
            where u.username = (?)', [$username]);

        $statement->execute([
            $username
        ]);

        foreach($statement->fetchAll() as $user) {

            $newUser = new User($user->email, $user->username, $user->first_name,
                $user->last_name, $user->password, $user->country, $user->city,
                $user->postalCode, $user->address, $user->role);
        }
        return $newUser;

    }


}