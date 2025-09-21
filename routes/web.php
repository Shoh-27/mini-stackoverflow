<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

Route::middleware('auth')->group(function () {
    Route::get('/questions/create', [QuestionController::class, 'create'])->middleware('auth')->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->middleware('auth')->name('questions.store');
    Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/questions/{question}/answers', [\App\Http\Controllers\AnswerController::class, 'store'])
    ->name('answers.store')
    ->middleware('auth');


require __DIR__.'/auth.php';
