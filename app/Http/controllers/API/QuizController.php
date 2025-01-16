<?php

namespace App\Http\controllers\API;

use App\Models\Questions;
use App\Models\Options;
use App\Models\Quizzes;
use App\Traits\Validator;
use Src\Auth;

class QuizController{

    use Validator;
    public function store(){
    
        $quizItems=$this->validate([
            'title'=>'string',
            'description'=>'string',
            'time_limit'=> 'integer',
            'questions'=>'array',
        ]);


        $quiz=new Quizzes();
        $question=new Questions();
        $options=new Options();
        $auth = new class {
            use Auth;
        };
        $user = $auth->user();

        $quiz_id=$quiz->create(
            $quizItems['title'],
            $quizItems['description'],
            $user['id'],
            $quizItems['time_limit']
        );

        $questions=$quizItems['questions'];

        foreach($questions as $questionItem){

            $question_id=$question->create(
                $quiz_id,
                $questionItem['quiz'],
            );

            $correct = $questionItem['correct'];

        foreach ($questionItem['options'] as $key => $optionItem) {
            //$isCorrect = isset($questionItem['correct']) && $questionItem['correct'] == $key ? 1 : 0;

            $options->create(
                $question_id,
                $optionItem,
                $correct==$key,
            );
        }
    }


            apiResponse([
                'message'=>'quiz created succesfully'
            ],201);
            
        }

   
    }
