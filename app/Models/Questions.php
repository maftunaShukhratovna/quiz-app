<?php

namespace App\Models;

use App\Models\DB;

class Questions extends DB{
    public function create($quiz_id, $question_text){
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO questions (question_text, quiz_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        $stmt->bind_param("si", $question_text, $quiz_id);
        $stmt->execute();
        $stmt->close();
        return $conn->insert_id;
    }

    public function getWithOptions(int $quizId): array
{
    // Savollarni olish
    $stmt = $this->conn->prepare("SELECT id, question_text, quiz_id, created_at, updated_at FROM questions WHERE quiz_id = ?");
    $stmt->bind_param('i', $quizId);
    $stmt->execute();

    $result = $stmt->get_result();
    $questions = $result->fetch_all(MYSQLI_ASSOC);

    if (empty($questions)) {
        return [];
    }

    $questionIds = array_column($questions, 'id');

    if (empty($questionIds)) {
        foreach ($questions as &$question) {
            $question['options'] = [];
        }
        return $questions;
    }

    $placeholders = implode(',', array_fill(0, count($questionIds), '?'));
    $query = "SELECT id AS option_id, question_id, option_text, is_correct FROM options WHERE question_id IN ($placeholders)";
    $stmt = $this->conn->prepare($query);

    $types = str_repeat('i', count($questionIds));
    $stmt->bind_param($types, ...$questionIds);
    $stmt->execute();
    $result = $stmt->get_result();
    $options = $result->fetch_all(MYSQLI_ASSOC);


    $groupedOptions = [];
    foreach ($options as $option) {
        $groupedOptions[$option['question_id']][] = $option;
    }

    foreach ($questions as &$question) {
        $question['options'] = $groupedOptions[$question['id']] ?? [];
    }

    return $questions;
}


    public function delete($id){
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM questions WHERE quiz_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}