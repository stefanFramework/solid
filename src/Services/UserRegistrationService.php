<?php


class UserRegistrationService
{
    private $repo;
    private $mailer;

    public function __construct(IUserRepository $userRepository, IMailer $mailer )
    {
        $this->repo = $userRepository;
        $this->mailer = $mailer;
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

    private function send100UserMail(User $user)
    {
        if (empty($user)) {
            return false;
        } else {
            if ($user->isUserNumber100()) {
                $result = $this->mailer->sendMail('Felicitaciones', 'Usted es el usuario numero 100!!');

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