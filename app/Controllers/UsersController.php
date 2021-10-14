<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\View;
use App\Repositories\MySqlUsersRepository;
use App\SessionSetter;
use App\TwigRenderer;
use PDO;
use Twig\Loader\FilesystemLoader;

class UsersController
{

    private MySqlUsersRepository $users;

    public function __construct()
    {
        $this->users = new MySqlUsersRepository();
    }

    public function login(): View
    {
        return new View('login.view.twig', ['username' => $_SESSION['username']]);
    }

    public function verify(): void
    {
        $user = $this->users->checkout($_POST['username'], $_POST['password']);

        if ($user) {
            SessionSetter::SetUser($user);
            header('Location: /todos');
        } else {
            header('Location: /login');
        }
    }

    public function logout(): void
    {
        SessionSetter::DestroySession();
        header('Location: /login');
    }

    public function register(): View
    {
        return new View('register.view.twig', ['username' => $_SESSION['username']]);
    }

    public function registrate(): void
    {
        $user = new User($_POST['username'], $_POST['password'], 'default');
        $this->users->createUser($user);

        header('Location: /login');
    }

    public function showEdit(): View
    {
        $user = $this->users->searchById($_SESSION['id']);
        return new View('useredit.view.twig', ['username' => $_SESSION['username'], 'user' => $user]);
    }

    public function edit(){

        $this->users->updateUser($_SESSION['id'], $_POST['username'], $_POST['password']);
        $_SESSION['username'] = $_POST['username'];
        header('Location: /todos');
    }


}