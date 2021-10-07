<?php

namespace App\Controllers;



use App\Repositories\MySqlTodoRepository;
use PDO;

class DeleteTodoController{


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

    public function delete(): void{


        $this->todos->delete($_POST['id']);

        header('Location: /todos');
    }

}