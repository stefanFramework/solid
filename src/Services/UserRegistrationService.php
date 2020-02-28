<?php


class UserRegistrationService
{
    private $userRepository;
    private $mailer;

    public function __construct(IUserRepository $userRepository, IMailer $mailer )
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    public function registrateNewUser($data)
    {
        try {
            $user = new User();
            $user->user = $data['user'];
            $user->password = $data['password'];

            $this->assertUserAlreadyNotExists($user);
            $this->userRepository->save($user);
            $this->notifyUser($user);

        } catch(UserAlreadyExistsException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    private function assertUserAlreadyNotExists($user)
    {
        $user = $this->userRepository->getUserByUserAndPsw($user->user, AuthenticationHelper::hash($user->password));

        if (!is_null($user)) {
            throw new UserAlreadyExistsException('User Already Exists');
        }
    }

    private function notifyUser(User $user)
    {
        if (!$user->isUserNumber100()) {
            return;
        }

        $this->mailer->sendMail('Felicitaciones', 'Usted es el usuario numero 100!!');
    }

}