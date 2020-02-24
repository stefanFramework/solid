<?php


class RegistrateUserController
{
    private $registrationService;

    public function __construct()
    {
        $this->registrationService = new UserRegistrationService(
            new UserRepositoryMySql(),
            new GMailAPI()
        );
    }

    public function register()
    {
        $user = Input::get('user');
        $psw = Input::get('password');

        $result = $this->registrationService->newUser([
            'user' => $user,
            'password' => $psw
        ]);

        if ($result){
            Redirect::to('home');
        } else {
            Redirect::withError('login', 'Usuario o Contraseña incorrectos');
        }
    }

}