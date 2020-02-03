<?php


class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function login()
    {

    }

    public function register()
    {
        $user = Input::get('user');
        $psw = Input::get('password');

        $result = $this->userService->newUser([
            'user' => $user,
            'password' => $psw
        ]);

        if ($result){
            Redirect::to('home');
        } else {
            Redirect::withError('login', 'Usuario o Contraseña incorrectos');
        }
    }

    public function loadProfile($id)
    {

    }
}