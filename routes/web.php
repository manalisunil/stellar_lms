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

Route::get('/', function () 
{
	if(Auth::check())
		return redirect('/dashboard');
	else
        return redirect('/login');
});

Auth::routes();

Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

//user 
Route::get('settings/user',[App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('auth');
Route::post('addUser',[\App\Http\Controllers\UserController::class, 'adduser'])->name('addUser');
Route::post('edit_user',[\App\Http\Controllers\UserController::class, 'edit_user'])->name('edit_user');
Route::post('updateUser',[\App\Http\Controllers\UserController::class, 'updateUser'])->name('updateUser');
Route::any('/userStatus/{userid?}', [App\Http\Controllers\UserController::class, 'userStatus']);
Route::post('user_view_topic',[\App\Http\Controllers\UserController::class, 'user_view'])->name('user_view_topic');


//company 
Route::get('settings/company',[App\Http\Controllers\CompanyController::class, 'viewCompany'])->name('company_list');
Route::post('/submit_company', [App\Http\Controllers\CompanyController::class, 'submitCompany'])->name('submit_company');
Route::get('/edit_company/{id}',[\App\Http\Controllers\CompanyController::class, 'editCompany'])->name('edit_company');
Route::post('/update_company',[\App\Http\Controllers\CompanyController::class, 'updateCompany'])->name('update_company');
Route::any('/companyStatus/{companyid?}', [App\Http\Controllers\CompanyController::class, 'companyStatus'])->name('company_status');

//chapter
Route::get('settings/chapter',[App\Http\Controllers\ChapterController::class, 'index'])->name('chapter')->middleware('auth');
Route::post('addChapter',[\App\Http\Controllers\ChapterController::class, 'add_chapter'])->name('addChapter');
Route::post('edit_chapter',[\App\Http\Controllers\ChapterController::class, 'edit_chapter'])->name('edit_chapter');
Route::post('updateChapter',[\App\Http\Controllers\ChapterController::class, 'updateChapter'])->name('updateChapter');
Route::any('/chapterstatus/{courseid?}', [App\Http\Controllers\ChapterController::class, 'chapterstatus'])->name('chapterstatus');
Route::post('chapter_view_topic',[\App\Http\Controllers\ChapterController::class, 'view_topic'])->name('chapter_view_topic');

//topic
Route::get('settings/topic',[App\Http\Controllers\TopicsController::class, 'index'])->name('topic')->middleware('auth');
Route::post('add_topic',[\App\Http\Controllers\TopicsController::class, 'add_topic'])->name('add_topic');
Route::post('edit_topic',[\App\Http\Controllers\TopicsController::class, 'edit_topic'])->name('edit_topic');
Route::post('update_topic',[\App\Http\Controllers\TopicsController::class, 'updatetopic'])->name('update_topic');
Route::any('/topicStatus/{topicid?}', [App\Http\Controllers\TopicsController::class, 'topicStatus']);
Route::post('topic_view_topic',[\App\Http\Controllers\TopicsController::class, 'view_topic'])->name('topic_view_topic');

//Course
Route::get('settings/view_courses', [App\Http\Controllers\CourseController::class, 'viewCourse'])->name('course_list');
Route::post('/submit_course', [App\Http\Controllers\CourseController::class, 'submitCourse'])->name('submit_course');
Route::any('/courseStatus/{courseid?}', [App\Http\Controllers\CourseController::class, 'courseStatus'])->name('course_status');
Route::get('/edit_course/{id}',[\App\Http\Controllers\CourseController::class, 'editCourse'])->name('edit_course');
Route::post('/update_course',[\App\Http\Controllers\CourseController::class, 'updateCourse'])->name('update_course');
Route::get('/course_details_view/{courseid}', [App\Http\Controllers\CourseController::class, 'courseDetails'])->name('detailsview');
Route::get('/view_course_banner/{id}',[\App\Http\Controllers\CourseController::class, 'viewBanner'])->name('view_banner');
Route::get('/view_course_document/{id}',[\App\Http\Controllers\CourseController::class, 'viewDocument'])->name('view_document');

//Subject
Route::get('settings/view_subjects', [App\Http\Controllers\SubjectController::class, 'viewSubject'])->name('subject_list');
Route::post('/submit_subject', [App\Http\Controllers\SubjectController::class, 'submitSubject'])->name('submit_subject');
Route::any('/subjectStatus/{subjectid?}', [App\Http\Controllers\SubjectController::class, 'subjectStatus'])->name('subject_status');
Route::post('/edit_subject',[\App\Http\Controllers\SubjectController::class, 'editSubject'])->name('edit_subject');
Route::post('/update_subject',[\App\Http\Controllers\SubjectController::class, 'updateSubject'])->name('update_subject');

//Course Subject Mapping

Route::get('settings/view_mapping', [App\Http\Controllers\SubjectController::class, 'viewMapping'])->name('mapping_list');
Route::post('/course_subject_mapping', [App\Http\Controllers\SubjectController::class, 'submitCousreSubjectMapping'])->name('submit_csmapping');
Route::any('/mappingStatus/{mappingid?}', [App\Http\Controllers\SubjectController::class, 'mappingStatus'])->name('mapping_status');
Route::post('/edit_mapping',[\App\Http\Controllers\SubjectController::class, 'editMapping'])->name('edit_mapping');
Route::post('/update_mapping',[\App\Http\Controllers\SubjectController::class, 'updateMapping'])->name('update_mapping');

