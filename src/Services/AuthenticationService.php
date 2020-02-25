<?php


class AuthenticationService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new UserRepositoryMySql();
    }

    public function authenticate($user, $password)
    {
        return $this->repo->getUserByUserAndPsw($user, AuthenticationHelper::hash($password));
    }
}