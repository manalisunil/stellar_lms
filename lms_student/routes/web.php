<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/courses', [App\Http\Controllers\Course_detailController::class, 'index'])->name('courses');
Route::get('/topic_videos', [App\Http\Controllers\Course_detailController::class, 'topic_videos'])->name('topic_videos');
Route::get('/topic_play_video', [App\Http\Controllers\Course_detailController::class, 'topic_play_video'])->name('topic_play_video');
Route::get('/quiz_test', [App\Http\Controllers\Course_detailController::class, 'quiz_test'])->name('quiz_test');


