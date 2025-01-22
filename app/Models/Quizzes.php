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
    
    public function getByQuizId($quiz_id, $user_id){
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM quizzes WHERE user_id = ? and id = ?");
        $stmt->bind_param("ii", $user_id, $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    public function update($title, $description, $id){
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE quizzes SET title = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $description, $id);
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

    public function getbyoption(int $quizId){
        $conn = $this->getConnection();
        $stmt = $conn->prepare( "
        SELECT 
            q.id AS question_id,
            q.question_text,
            o.id AS option_id,
            o.option_text,
            o.is_correct
        FROM 
            quizzes AS z
        JOIN 
            questions AS q ON z.id = q.quiz_id
        JOIN 
            options AS o ON q.id = o.question_id
        WHERE 
            z.id = ?
    ");
        $stmt->bind_param("i", $quizId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        //dd($result->fetch_all(MYSQLI_ASSOC));
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}