<?php


class UserRegistrationService
{
    private $repo;
    private $gmail;

    public function __construct()
    {
        $this->repo = new UserRepositoryMySql();
        $this->gMail = new GMailAPI();
    }

    public function newUser($data)
    {
        $user = new User();
        $user->user = $data['user'];
        $user->password = $data['password'];

        if (!$this->checkUser($user)) {
            return false;
        } else {
            $this->repo->save($user);
            return $this->send100UserMail($user);
        }
    }

    private function checkUser($user)
    {
        $user = $this->repo->getUserByUserAndPsw($user->user, AuthenticationHelper::hash($user->password));

        if ($user === null) {
            return true;
        } else {
            return false;
        }
    }

    private function send100UserMail($user)
    {
        if (empty($user)) {
            return false;
        } else {
            $user100 = $this->repo->getUserById($user->id);

            if ($user100->id == 100) {
                $result = $this->gMail->sendMail('Felicitaciones', 'Usted es el usuario numero 100!!');

                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }

}