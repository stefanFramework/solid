<?php

class User
{
    public $id;
    public $user;
    public $password;

    public $name;
    public $lastName;
    public $birthDay;
    public $address;

    public function isUserNumber100()
    {
        return $this->id == 100;
    }
}