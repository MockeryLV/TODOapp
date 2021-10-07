<?php

namespace App\Repositories;

use App\Models\Collections\TodoCollection as TodoCollection;
use App\Models\Todo as Todo;
use PDO;

class MySqlTodoRepository{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): TodoCollection{
        $todos = [];
        $stmt = $this->pdo->query('SELECT * FROM todos');

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $todos[] =  new Todo($row['id'],$row['title'],$row['due'],$row['status']);
        }

        return new TodoCollection($todos);
    }

    public function addTodo(string $title, string $due, string $status): void{
        $sql = 'INSERT INTO todos(title, due, status) VALUES (:title, :due, :status)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['title' => $title, 'due' => $due, 'status' => $status]);
    }

    public function updateTodo(int $id, string $status):void{
        if($status == 'created'){

            $sql = "UPDATE todos SET status = 'completed' WHERE id = $id";
        }else{

            $sql = "UPDATE todos SET status = 'created' WHERE id = $id";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function delete(int $id){

        $sql = "DELETE FROM todos WHERE id = $id AND status = 'completed'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

}