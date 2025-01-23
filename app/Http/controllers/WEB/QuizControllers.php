<?php 

namespace App\Http\controllers\WEB;

use App\Models\Quizzes;

class QuizControllers{
    public function takequiz(string $unique_value){
        view('quiz/takequiz',['unique_value'=>$unique_value]);
    }
}