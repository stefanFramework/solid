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
        try {
            $user = Input::get('user');
            $psw = Input::get('password');

            $this->registrationService->registrateNewUser([
                'user' => $user,
                'password' => $psw
            ]);

            Redirect::to('home');

        } catch (\Exception $ex) {
            Redirect::withError('login', $ex->getMessage());
        }

    }

}