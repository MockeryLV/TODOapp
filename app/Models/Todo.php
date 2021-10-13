<?php

namespace App\Models;

class Todo
{

    private $id;

    private $title;

    private $due;

    private $status;

    private $userId;

    public function __construct(int $id, string $title, string $due, string $status, int $userId)
    {

        $this->id = $id;
        $this->title = $title;
        $this->due = $due;
        $this->status = $status;
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDue(): string
    {
        return $this->due;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

}