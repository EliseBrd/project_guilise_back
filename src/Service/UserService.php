<?php

namespace App\Service;

use App\Entity\User;



class UserService{

    public function createUser(string $email, string $password, string $role = 'ROLE_USER'): User
    {
        $user = new User();
        $user->setEmail($email);
        //TODO set a better password hashing mechanism
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $user->setRoles([$role]);

        return $user;
    }
}


