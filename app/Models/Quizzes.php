<?php

namespace App\Models;

use App\Models\DB;

class Quizzes extends DB{
    public function create($title, $description, $user_id, $time_limit){
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO quizzes (title, description, user_id, time_limit, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("ssii", $title, $description, $user_id, $time_limit);
        $stmt->execute();
        $stmt->close();
        return $conn->insert_id;
    }
    
    public function getByUserId($user_id){
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM quizzes WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    
    
    public function update($title, $description, $id, $time_limit){
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE quizzes SET title = ?, description = ?, time_limit=? WHERE id = ?");
        $stmt->bind_param("ssii", $title, $description, $time_limit, $id);
        $stmt->execute();
        $stmt->close();
    }
    
    public function delete($id){
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function find(int $quizId)
    {
        $query = "SELECT * FROM quizzes WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $quizId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    

}