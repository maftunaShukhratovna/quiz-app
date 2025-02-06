<?php

namespace App\Models;

class DB{
    public $host;
    public $user;
    public $pass;
    public $database;
    public $conn;

    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->database = $_ENV['DB_NAME'];
    
        $this->conn = new \mysqli($this->host, $this->user, $this->pass, $this->database);
    
    }

    public function getConnection(){
        return $this->conn;
    }
}

    