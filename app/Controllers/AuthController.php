<?php


namespace App\Controllers;

use App\Models\User;
use App\Repositories\MySqlTodoRepository;
use App\Repositories\MySqlUserController as MySqlUsersRepository;
use PDO;
use App\SessionSetter;

class AuthController
{
    private MySqlUserController $users;

    public function __construct()
    {

        $host = 'localhost';
        $user = 'root';
        $password = '';
        $dbname = 'todo';

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

        $pdo = new PDO($dsn, $user, $password);

        $this->users = new MySqlUserController($pdo);
    }

    public function login(): void{
        require_once 'app/Views/login.template.php';
    }

    public function checkout(): void{

        $user = $this->users->checkout($_POST['username'], $_POST['password']);
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
        $this->users->createUser($user);

        header('Location: /login');
    }

}