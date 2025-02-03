<?php 

namespace App\Http\controllers\WEB;

use App\Models\Quizzes;

class QuizControllers{
    public static function takeQuiz(string $uniqueValue): void
    {
        view('quiz/takequiz', [
            'uniqueValue' => $uniqueValue
        ]);
    }
}