<?php

namespace App\Repositories;

use App\Models\Collections\TodoCollection as TodoCollection;
use App\Models\Todo as Todo;
use App\Models\User;
use PDO;

class MySqlUsersRepository
{

    private PDO $pdo;

    public function __construct()
    {
        require_once 'config.php';
        $pdo = new PDO($dsn, $user, $password);
        $this->pdo = $pdo;
    }


    public function checkout(string $username, string $password): ?User
    {


        $sql = "SELECT * FROM users WHERE username=:username";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return new User($user['username'], $user['password'], $user['access'], $user['id']);
        } else {
            return NULL;
        }

    }

    public function createUser(User $user): void
    {
        $sql = 'SELECT * FROM users WHERE username=:username';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $user->getUsername()]);
        if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
            $sql = 'INSERT INTO users (username, password, access) VALUES (:username, :password, :access)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['username' => $user->getUsername(), 'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT), 'access' => $user->getAccess()]);
            header("Location: /login");
        } else {
            header("Location: /register");
            echo 'Username is already in use!';
        }
    }

    public function updateUser(int $id, string $username, string $password)
    {
        $sql = 'UPDATE users SET username = :username, password = :password WHERE id=:id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'id' => $id, 'password' => password_hash($password, PASSWORD_BCRYPT)]);
    }

    public function searchById(int $id): User{
        $sql = 'SELECT * FROM users WHERE id=:id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $user = new User($data['username'], $data['password'], $data['access'], $data['id']);
        return $user;
    }

}