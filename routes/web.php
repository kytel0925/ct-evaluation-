<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Generic;
use App\Http\Controllers\PersonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $questions = [
        'phase_1' => collect(range(1, 15))->map(function($index){
            $routeName = "question-1.{$index}";

            return [
                'value' => $routeName,
                'text' => "Question $index",
                'route' => route($routeName),
            ];
        }),
    ];

    return view('home', compact('questions'));
});

Route::get('/questions/1.1', [Generic::class, 'question1'])->name('question-1.1');
Route::get('/questions/1.2', [Generic::class, 'question2'])->name('question-1.2');
Route::get('/questions/1.3', [Generic::class, 'question3'])->name('question-1.3');
Route::get('/questions/1.4', [Generic::class, 'question4'])->name('question-1.4');
Route::get('/questions/1.5', [Generic::class, 'question5'])->name('question-1.5');
Route::get('/questions/1.6', [Generic::class, 'question6'])->name('question-1.6');
Route::get('/questions/1.7', [Generic::class, 'question7'])->name('question-1.7');
Route::get('/questions/1.8', [Generic::class, 'question8'])->name('question-1.8');
Route::get('/questions/1.9', [Generic::class, 'question9'])->name('question-1.9');
Route::get('/questions/1.10', [Generic::class, 'question10'])->name('question-1.10');
Route::get('/questions/1.11', [Generic::class, 'question11'])->name('question-1.11');
Route::get('/questions/1.12', [Generic::class, 'question12'])->name('question-1.12');
Route::get('/questions/1.13', [Generic::class, 'question13'])->name('question-1.13');
Route::get('/questions/1.14', [Generic::class, 'question14'])->name('question-1.14');
Route::get('/questions/1.15', [Generic::class, 'question15'])->name('question-1.15');
Route::get('/person', [PersonController::class, 'index'])->name('person.index');
Route::delete('/person/{id}', [PersonController::class, 'destroy'])->name('person.destroy');
