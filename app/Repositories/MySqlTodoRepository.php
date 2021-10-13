<?php

namespace App\Repositories;

use App\Models\Collections\TodoCollection as TodoCollection;
use App\Models\Todo as Todo;
use PDO;

class MySqlTodoRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
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

}