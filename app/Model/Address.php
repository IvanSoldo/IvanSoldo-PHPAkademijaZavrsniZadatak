<?php

namespace App\Model;

class Address{

    private $city;
    private $postalCode;
    private $address;

    /**
     * Address constructor.
     * @param $city
     * @param $postalCode
     * @param $address
     */
    public function __construct($city, $postalCode, $address)
    {
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }




}