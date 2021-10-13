<?php


namespace App\Controllers;

use App\Models\View;
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
        $this->todos = new MySqlTodoRepository();
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

    public function index(): View
    {

        $todos = $this->todos->getAll()->getTodos();
        return new View('main.view.twig', ['todos' => $todos, 'username' => $_SESSION['username']]);

    }

    public function create(): View
    {
        return new View('create.view.twig', ['username' => $_SESSION['username']]);

    }
}