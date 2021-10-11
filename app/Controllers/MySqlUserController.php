<?php

namespace App\Controllers;

use App\Models\User;
use PDO;
class MySqlUserController{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function checkout(string $username, string $password): ?User{



        $sql = "SELECT * FROM users WHERE username=:username AND password=:password";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['username' => $username, 'password' => base64_encode($password)]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            return new User($user['username'], $user['password'], $user['access'], $user['id']);
        }else{
            return NULL;
        }

    }

    public function createUser(User $user): void{
        $sql = 'INSERT INTO users (username, password, access) VALUES (:username, :password, :access)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $user->getUsername(), 'password' => base64_encode($user->getPassword()), 'access' => $user->getAccess()]);
    }



}