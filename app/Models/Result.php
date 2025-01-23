<?php

namespace App\Models;

use App\Models\DB;
use \Exception;

class Result extends DB{
    public function create($user_id, $quiz_id, $limit) {
        $conn = $this->getConnection();
        
        $finished_at = date('Y-m-d H:i:s', strtotime("+{$limit} minutes"));
        
        $stmt = $conn->prepare("INSERT INTO results (user_id, quiz_id, started_at, finished_at) VALUES (?, ?, NOW(), ?)");
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }
        
        $stmt->bind_param("iis", $user_id, $quiz_id, $finished_at);
        
        if (!$stmt->execute()) {
            throw new Exception("Query execution failed: " . $stmt->error);
        }
        
        $stmt->close();
        // return $conn->insert_id;
    }
    

}