<?php

namespace App\Controllers;

use App\Models\User;
use App\SessionSetter;
use PDO;
class UsersController{

    private PDO $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $dbname = 'todo';

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

        $this->pdo = new PDO($dsn, $user, $password);
    }


    public function checkout(string $username, string $password): ?User{



        $sql = "SELECT * FROM users WHERE username=:username";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])){
            return new User($user['username'], $user['password'], $user['access'], $user['id']);
        }else{
            return NULL;
        }

    }

    public function createUser(User $user): void{
        $sql = 'INSERT INTO users (username, password, access) VALUES (:username, :password, :access)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $user->getUsername(), 'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT), 'access' => $user->getAccess()]);
    }


    public function login(): void{
        require_once 'app/Views/login.template.php';
    }

    public function verify(): void{
        $user = $this->checkout($_POST['username'], $_POST['password']);

        if($user){
            SessionSetter::SetUser($user);
            header('Location: /todos');
        }
        else{
            header('Location: /login');
        }
    }

    public function logout(): void{
        SessionSetter::DestroySession();
        header('Location: /login');
    }

    public function register():void{
        require_once 'app/Views/register.template.php';
    }

    public function registrate(): void{
        $user = new User($_POST['username'],$_POST['password'],'default');
        $this->createUser($user);

        header('Location: /login');
    }


}