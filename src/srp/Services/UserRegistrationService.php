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
        try {
            $user = new User();
            $user->user = $data['user'];
            $user->password = $data['password'];

            $this->validateUserExists($user);
            $this->repo->save($user);
            $this->send100UserMail($user);

        } catch(UserAlreadyExistsException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    private function validateUserExists($user)
    {
        $user = $this->repo->getUserByUserAndPsw($user->user, AuthenticationHelper::hash($user->password));

        if (!is_null($user)) {
            throw new UserAlreadyExistsException('User Already Exists');
        }
    }

    private function send100UserMail(User $user)
    {
        if ($user->isUserNumber100()) {
            $this->mailer->sendMail('Felicitaciones', 'Usted es el usuario numero 100!!');
        }
    }

}