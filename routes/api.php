<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ComplaintController;


// ...................................specialization.....................................

Route::group([], function () {

    Route::group(['middleware' => 'isAdmin'], function () {
        Route::post('/add-specialization', [SpecializationController::class, 'store']);
        Route::put('/update-specialization/{specialization_uuid}', [SpecializationController::class, 'update']);
        Route::delete('/delete-specialization/{specialization_uuid}', [SpecializationController::class, 'destroy']);
    });

    Route::get('/all-specializations', [SpecializationController::class, 'index']);
    Route::post('/search-specializations', [SpecializationController::class, 'show']);
});

//....................................end specialization.................................

//......................................subject............................................
Route::group(['middleware' => 'isAdmin'], function () {

    Route::post('/add-subject', [SubjectController::class, 'store']);
    Route::put('/update-subject/{subject_uuid}', [SubjectController::class, 'update']);
    Route::delete('/delete-subject/{subject_uuid}', [SubjectController::class, 'destroy']);
});

Route::get('/specialization-subjects/{specialization_uuid}/{level}', [SubjectController::class, 'show'])->middleware(['isLoggedIn', 'isPayed']);

//....................................end subject........................................

//.....................................question.........................................

Route::group(['middleware' => 'isLoggedIn'], function () {

    Route::group(['middleware' => 'isAdmin'], function () {
        Route::post('/add-question', [QuestionController::class, 'store']);
        Route::delete('/delete-question/{question_uuid}', [QuestionController::class, 'destroy']);
    });

    Route::post('/book-questions/{level}', [QuestionController::class, 'bookQuestions']);
    Route::post('/exam-dates/{level}', [QuestionController::class, 'getLastExams']);
    Route::get('/exam-questions/{question_uuid}/{level}', [QuestionController::class, 'examQuestions']);
    Route::get('/bank-questions/{level}', [QuestionController::class, 'bankQuestions']);
    Route::post('/test-questions', [QuestionController::class, 'testQuestions']);
});

//.....................................end question.....................................

//.....................................favorite...........................................

Route::group(['middleware' => 'isLoggedIn'], function () {

    Route::get('/favorite/all', [FavoriteController::class, 'index']);
    Route::post('/favorite/store', [FavoriteController::class, 'store']);
    Route::delete('/favorite/delete/{question_uuid}', [FavoriteController::class, 'destroy']);
});

//.....................................end favorite...............................................

//.....................................complaint.................................................

Route::post('/complaint/store', [ComplaintController::class, 'store'])->middleware('isLoggedIn');

//....................................end complaint...............................................

//...................................user ................................................

Route::group(['middleware' => 'isLoggedIn'], function () {

    Route::post('/upload-photo', [UserController::class, 'uploadPhoto']);
    Route::patch('/update-user', [UserController::class, 'update'])->middleware('isLoggedIn');
});

//..................................end user..............................................

//..................................slider............................................

Route::get('/get-sliders', [SliderController::class, 'index']);
Route::post('/add-slider', [SliderController::class, 'store'])->middleware('isAdmin');

//..................................end slider...................................

//..................................auth..........................................

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('isLoggedIn');

//..................................end auth......................................
