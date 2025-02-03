<?php

// use Source\Router;
// use App\controllers\API\UserController;

//Router::get('/todos', UserController::class . 'index');

use App\Http\controllers\API\QuizController;
use App\Http\controllers\WEB\HomeController;
use src\Router;
use App\Http\controllers\WEB\QuizControllers;

Router::get('/',[HomeController::class,'home']);
Router::get('/about',[HomeController::class,'about']);
Router::get('/login',[HomeController::class,'login']);
Router::get('/register',[HomeController::class,'register']);
Router::get('/dashboard', [HomeController::class, 'homepage']);
Router::get('/createquiz', [HomeController::class, 'createquiz']);
Router::get('/myquiz', [HomeController::class, 'myquiz']);
Router::get('/statistic', [HomeController::class, 'statistic']);
// Router::get('/takequiz', [QuizControllers::class, 'takequiz']);
Router::get('/updatequiz/{id}', [HomeController::class, 'updatequiz']);
Router::get('/take-quiz/{id}', [QuizControllers::class, 'takeQuiz']);

Router::notFound();

