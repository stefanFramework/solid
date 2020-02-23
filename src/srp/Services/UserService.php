<?php


class UserService
{
    private $repo;
    private $gMail;

    public function __construct()
    {
        $this->repo = new UserRepositoryMySql();
        $this->gMail = new GMailAPI();
    }

    public function auth($user, $password)
    {
        return $this->repo->getUserByUserAndPsw($user, AuthenticationHelper::hash($password));
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

    public function loadProfile($id)
    {
        return $this->repo->getUserById($id);
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

    private function checkUser($user)
    {
        $user = $this->repo->getUserByUserAndPsw($user->user, AuthenticationHelper::hash($user->password));

        if ($user === null) {
            return true;
        } else {
            return false;
        }
    }
}