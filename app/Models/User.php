<?php

namespace App\Models;

class User {


    private int $id;
    private string $username;
    private string $password;
    private string $access;

    public function __construct( string $username, string $password, string $access, int $id = 0)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->access = $access;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getAccess(): string
    {
        return $this->access;
    }

}


