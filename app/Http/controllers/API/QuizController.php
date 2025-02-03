<?php

namespace App\Http\controllers\API;

use App\Models\Questions;
use App\Models\Options;
use App\Models\Quizzes;
use App\Traits\Validator;
use Src\Auth;

class QuizController{

    use Validator;

    public function index(){
        $auth = new class {
            use Auth;
        };
        $user = $auth->user();

        $quizzes = (new Quizzes())->getByUserId($user['id']);
        //dd($user['id']);
        //dd($quizzes);

        
        apiResponse(['message' => $quizzes]);     
    }

    public function destroy(int $quiz_id){
        $quiz=new Quizzes();
        $quiz->delete($quiz_id);
        apiResponse([
            'message'=>'quiz deleted succesfully'
        ]);
    }

    public function updateQuiz(int $quiz_id){
        $quizItems = $this->validate([
            'title' => 'required',
            'description' => 'required',
            'timeLimit' => 'required',
        ]);

        $quiz = new Quizzes();
        $question = new Questions();
        $option = new Options();

        $quiz->update(
            $quizItems['title'],
            $quizItems['description'],
            $quiz_id,
            $quizItems['timeLimit'],
        );

        $question->delete($quiz_id);

        $questions = $quizItems['questions'];

        foreach ($questions as $questionItem) {
            $question_id = $question->create($quiz_id, $questionItem['quiz']);
            $correct = $questionItem['correct'];
            foreach ($questionItem['options'] as $key => $optionItem) {
                $option->create($question_id, $optionItem, $correct == $key);
            }
        }
        apiResponse(['message' => 'quiz successfully updated'], 201);
    }

    public function showByUniqueValue(string $unique_value){
        $quiz = (new Quizzes())->findByUniqueValue($unique_value);
        $questions = (new Questions())->getWithOptions($quiz['id']);
        apiResponse([
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }
 

    public function show(int $id){
        $quiz = (new Quizzes())->find($id);
        $questions = (new Questions())->getWithOptions($id);
        apiResponse([
            'quiz' => $quiz,
            'questions' => $questions
        ]);
        
    }



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
