<?php 

namespace App\Http\Controllers\API;

use App\Models\Result;
use App\Models\Quizzes;

use App\Traits\Validator;
use src\Auth;

class ResultController{
    use Validator;

    public function store(){
        $resultItems=$this->validate([
            'quiz_id'=>'required',
            'limit'=>'required',
        ]);

        $quiz=(new Quizzes())->find($resultItems['quiz_id']);

            $auth = new class {
                use Auth;
            };
            $user = $auth->user();
    
            $result=new Result();
    
            $result->create($user['id'], $quiz['id'], $quiz['limit']);
            
            apiResponse([
                'message'=>'Quiz result created successfully',
                'questions'=>$quiz['questions']
            ]);
        

        
    }

    
}