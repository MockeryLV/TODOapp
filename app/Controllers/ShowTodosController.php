<?php

namespace App\Controllers;
use App\Models\Collections\TodoCollection as TodoCollection;
use App\Repositories\MySqlTodoRepository;
use PDO;


class ShowTodosController{


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

    public function show(): void{


        $todos = $this->todos->getAll()->getTodos();

        require_once 'app/Views/main.template.php';

    }

}