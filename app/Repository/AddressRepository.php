<?php

namespace App\Repository;

use App\Core\Database;

class AddressRepository {

    public function insertAddress($data) {

        $db = Database::getInstance();
        $statement = $db->prepare('insert into address (city_name,postal_code,address) values (:city,:postalCode,:address);');
        $statement->bindValue('city', $data['city']);
        $statement->bindValue('postalCode', $data['postalCode']);
        $statement->bindValue('address', $data['address']);
        $statement->execute();
    }

    public function getAddressId($data) {
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