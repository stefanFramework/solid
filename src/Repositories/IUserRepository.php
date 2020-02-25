<?php


interface IUserRepository
{
    public function getUserByUserAndPsw($user, $psw);

    public function save(User $user);

    public function getUserById($id);
}