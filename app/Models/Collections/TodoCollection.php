<?php

namespace App\Models\Collections;

use App\Models\Todo as Todo;


class TodoCollection{

    private array $todos = [];

    public function __construct(array $todos)
    {

        foreach ($todos as $todo){
            if($todo instanceof Todo){
                $this->todos[] = $todo;
            }
        }

    }

    public function getTodos(): array
    {
        return $this->todos;
    }

}