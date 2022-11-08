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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Course
Route::get('/view_courses', [App\Http\Controllers\CourseController::class, 'viewCourse'])->name('course_list');
Route::post('/submit_course', [App\Http\Controllers\CourseController::class, 'submitCourse'])->name('submit_course');
Route::any('/courseStatus/{courseid?}', [App\Http\Controllers\CourseController::class, 'courseStatus'])->name('course_status');

//Subject
Route::get('/view_subjects', [App\Http\Controllers\SubjectController::class, 'viewSubject'])->name('subject_list');
Route::post('/submit_subject', [App\Http\Controllers\SubjectController::class, 'submitSubject'])->name('submit_subject');
Route::any('/subjectStatus/{subjectid?}', [App\Http\Controllers\SubjectController::class, 'subjectStatus'])->name('subject_status');
Route::post('/edit_subject',[\App\Http\Controllers\SubjectController::class, 'editSubject'])->name('edit_subject');
Route::post('/update_subject',[\App\Http\Controllers\SubjectController::class, 'updateSubject'])->name('update_subject');

//Course Subject Mapping
Route::get('/view_mapping', [App\Http\Controllers\SubjectController::class, 'viewMapping'])->name('mapping_list');
Route::post('/course_subject_mapping', [App\Http\Controllers\SubjectController::class, 'submitCousreSubjectMapping'])->name('submit_csmapping');
Route::any('/mappingStatus/{mappingid?}', [App\Http\Controllers\SubjectController::class, 'mappingStatus'])->name('mapping_status');




