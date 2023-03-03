<?php
namespace Services;

use Models\User;
use Repositories\UserRepository;

class UserService {

    private $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticateUser(string $username, string $password): ?User {
        $user = $this->userRepository->getUserByUsername($username);
        
        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user->getPassword())) {
            return null;
        }

        $user->setPassword("");
        return $user;
    }
}
?>
