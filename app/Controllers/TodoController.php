<?php


namespace App\Controllers;

use App\Repositories\MySqlTodoRepository;
use App\TwigRenderer;
use PDO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TodoController
{
    private MySqlTodoRepository $todos;

    public function __construct()
    {

        $host = 'localhost';
        $user = 'root';
        $password = '';
        $dbname = 'todo';

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

        $pdo = new PDO($dsn, $user, $password);

        $this->todos = new MySqlTodoRepository($pdo);
    }

    public function save(): void
    {
        $this->todos->addTodo($_POST['title'], $_POST['due'], $_POST['status']);

        header('Location: /todos');
    }

    public function delete(): void
    {


        $this->todos->delete($_POST['id']);

        header('Location: /todos');
    }

    public function update(): void
    {


        $this->todos->updateTodo($_POST['id'], $_POST['status']);

        header('Location: /todos');
    }

    public function index(): void
    {


        $todos = $this->todos->getAll()->getTodos();
        TwigRenderer::render('main.view.twig', ['todos' => $todos, 'username' => $_SESSION['username']]);

    }

    public function create(): void
    {

        TwigRenderer::render('create.view.twig', ['username' => $_SESSION['username']]);

    }
}