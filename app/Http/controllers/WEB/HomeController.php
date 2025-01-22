<?php

namespace App\Http\controllers\WEB;

use App\Models\Quizzes;

class HomeController{
    public function home(){
        view('home');
    }

    public function about(){
        view('about');
    }

    public function login(){
        view('auth/login');
    }

    public function register(){
        view('auth/register');
    }

    public function homepage(){
        view('dashboard/home');
    }

    public function myquiz(){
        view('dashboard/myquiz');
    }

    public function createquiz(){
        view('dashboard/createquiz');
    }

    public function statistic(){
        view('dashboard/statistic');
    }

    public function takequiz(){
        view('quiz/takequiz');
    }

    public function updatequiz(int $quiz_id){
        $data=(new Quizzes())->getbyoption($quiz_id);
        view('dashboard/updatequiz', $data);

    }
    public function components($route){
        view($route);
    }
}


