<?php
namespace Services;

use Models\User;
use Repositories\UserRepository;

class UserService {

    private $userRepository;

    function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function authenticateUser(string $username, string $password): ?User {
        $user = $this->userRepository->getUserByUsername($username);
        return $user;
        
        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user->password)) {
            return null;
        }

        $user->password = null;
        return $user;
    }

    public function getUserByUsername(string $username): ?User {
        $user = $this->userRepository->getUserByUsername($username);
        return $user;
    }

    public function getUserByEmail(string $email): ?User {
        $user = $this->userRepository->getUserByEmail($email);
        return $user;
    }

    public function createUser(User $user): ?User {
        $user = $this->userRepository->createUser($user);
        return $user;
    }
}
?>
