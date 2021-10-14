<?php

namespace App\Repositories;

use App\Models\Collections\TodoCollection as TodoCollection;
use App\Models\Todo as Todo;
use PDO;

class MySqlTodoRepository
{

    private PDO $pdo;

    public function __construct()
    {
        require_once 'config.php';
        $pdo = new PDO($dsn, $user, $password);
        $this->pdo = $pdo;
    }

    public function getAll(): TodoCollection
    {
        $todos = [];
        $sql = 'SELECT * FROM todos WHERE user_id=?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([(int)$_SESSION['id']]);


        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $todos[] = new Todo($row['id'], $row['title'], $row['due'], $row['status'], (int)$row['user_id']);

        }

        return new TodoCollection($todos);
    }

    public function addTodo(string $title, string $due, string $status): void
    {
        $sql = 'INSERT INTO todos(title, due, status, user_id) VALUES (:title, :due, :status, :user_id)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['title' => $title, 'due' => $due, 'status' => $status, 'user_id' => $_SESSION['id']]);
    }

    public function updateTodo(int $id, string $status): void
    {
        if ($status == 'created') {

            $sql = "UPDATE todos SET status = 'completed' WHERE id = :id";
        } else {

            $sql = "UPDATE todos SET status = 'created' WHERE id = :id";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function delete(int $id)
    {

        $sql = "DELETE FROM todos WHERE id = :id AND status = 'completed'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }


    public function getById(int $id): Todo{
        $sql = 'SELECT * FROM todos WHERE id=?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        $todo = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Todo($todo['id'], $todo['title'], $todo['due'], $todo['status'], $todo['user_id']);
    }

    public function editTodo(int $id, string $title, string $due, string $status){
        $sql = "UPDATE todos SET status = :status, title = :title, due = :due WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'status' => $status, 'title' => $title, 'due' => $due]);
    }

}