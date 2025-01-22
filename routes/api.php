<?php

use src\Router;
use App\Http\controllers\API\UserController;
use App\Http\controllers\API\QuizController;


Router::get('/api/users/getInfo',[UserController::class,'show'],'auth:api');

Router::post('/api/login', [UserController::class , 'login']);
Router::post('/api/register', [UserController::class , 'store']);

Router::post('/api/quizzes', [QuizController::class , 'store'], 'auth:api');
Router::get('/api/quizzes', [QuizController::class , 'index'], 'auth:api');
Router::delete('/api/quizzes/{id}', [QuizController::class , 'destroy'], 'auth:api');
// Router::po('/api/updatequiz/{id}', [QuizController::class , 'updateQuiz'], 'auth:api');
Router::put('/api/updatequiz/{id}', [QuizController::class , 'updateQuiz'], 'auth:api');
Router::get('/api/quizzes/{id}', [QuizController::class , 'show'], 'auth:api');









Router::notFound();