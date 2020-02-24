<?php


class UserRepositoryMySql implements IUserRepository
{
    public function getUserByUserAndPsw($user, $psw)
    {
        return null;
    }

    public function save(User $user)
    {
        return true;
    }

    public function getUserById($id)
    {
        return null;
    }
}