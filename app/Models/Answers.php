<?php

namespace App\Models;

use App\Models\DB;

class Answers extends DB {
    
    public function find(int $id): array|null {
        $query = "SELECT * FROM answers WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create(int $resultId, int $optionId): bool {
        $query = "INSERT INTO answers (result_id, option_id) VALUES(?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $resultId, $optionId);
        return $stmt->execute();
    }
}
