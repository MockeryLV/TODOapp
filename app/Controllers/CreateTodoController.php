<?php

namespace App\Controllers;

use App\Repositories\MySqlTodoRepository;
use PDO;

class CreateTodoController{

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

    public function create(): void{
         $this->todos->addTodo($_POST['title'],$_POST['due'],$_POST['status']);

         header('Location: /todos');
    }

}