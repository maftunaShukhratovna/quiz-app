<?php 

namespace App\Http\Controllers\API;

use App\Models\Result;
use App\Models\Quizzes;
use App\Traits\Validator;
use src\Auth;

class ResultController {
    use Validator;

    public function store() {
        $resultItems = $this->validate([
            'quiz_id' => 'required|integer',
        ]);

        $quiz = (new Quizzes())->find($resultItems['quiz_id']);
        if ($quiz) {
            $result = new Result();

            $auth = new class {
                use Auth;
            };

            $user = $auth->user();

        
            $resultUser = $result->getUserResult($user['id'], $quiz['id']);

            if ($resultUser) {
                $startedAt = strtotime($resultUser['started_at']);
                $finishedAt = strtotime($resultUser['finished_at']);

                $diffInSeconds = abs($finishedAt - $startedAt);
                $minutes = floor($diffInSeconds / 60);
                $seconds = $diffInSeconds % 60;

                $timeDiff = sprintf("%02d:%02d", $minutes, $seconds);

                apiResponse([
                    'errors' => [
                        'message' => 'You have already taken this quiz!'
                    ],
                    'data' => [
                        'result' => [
                            'id' => $resultUser['id'],
                            'quiz_id' => $resultUser['quiz_id'],
                            'started_at' => $resultUser['started_at'],
                            'time_taken' => $timeDiff,
                        ]
                    ]
                ], 404);
                return;
            }

            
            $resultData = $result->create(
                $user['id'],
                $quiz['id'],
                $quiz['time_limit']
            );

            apiResponse([
                'message' => 'Result stored successfully',
                'result' => $resultData
            ]);
            return;
        }

        apiResponse(['errors' => [
            'message' => 'Quiz not found'
        ]]);
    }
}
