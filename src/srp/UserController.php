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
        $user = Input::get('user');
        $psw = Input::get('password');

        $result = $this->userService->auth($user, $psw);

        if (!is_null($result)) {
            // User found ...
            Redirect::to('Home');
        } else {
            Redirect::withError('login', 'Usuario o Contraseña incorrectos');
        }
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
        $user = $this->userService->loadProfile($id);

        $data = [
            'id' => $user->id,
            'user' => $user->user,
            'name' => $user->name,
            'last_name' => $user->lastName,
            'birth_day' => $user->birthDay,
            'address' => $user->address
        ];

        if (!is_null($user)) {
            View::render('user.profile', $data);
        } else {
            Redirect::withError('login', 'Usuario o Contraseña incorrectos');
        }
    }
}