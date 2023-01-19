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
Route::group(['middleware' => 'prevent-back-history'],function(){
Route::get('/', function () 
{
	if(Auth::check())
		return redirect('/home');
	else
        return redirect('/login');
});

Auth::routes();

Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::post('/update_profile', [App\Http\Controllers\ProfileController::class,'update_profile'])->name('update_profile');

//user 
Route::get('settings/user',[App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('auth');
Route::post('addUser',[\App\Http\Controllers\UserController::class, 'adduser'])->name('addUser');
Route::post('edit_user',[\App\Http\Controllers\UserController::class, 'edit_user'])->name('edit_user');
Route::post('updateUser',[\App\Http\Controllers\UserController::class, 'updateUser'])->name('updateUser');
Route::any('/userStatus/{userid?}', [App\Http\Controllers\UserController::class, 'userStatus']);
Route::post('user_view_topic',[\App\Http\Controllers\UserController::class, 'user_view'])->name('user_view_topic');


//company 
Route::get('settings/company',[App\Http\Controllers\CompanyController::class, 'viewCompany'])->name('company_list')->middleware('auth');
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
Route::get('settings/view_courses', [App\Http\Controllers\CourseController::class, 'viewCourse'])->name('course_list')->middleware('auth');
Route::post('/submit_course', [App\Http\Controllers\CourseController::class, 'submitCourse'])->name('submit_course');
Route::any('/courseStatus/{courseid?}', [App\Http\Controllers\CourseController::class, 'courseStatus'])->name('course_status');
Route::get('/edit_course/{id}',[\App\Http\Controllers\CourseController::class, 'editCourse'])->name('edit_course')->middleware('auth');
Route::post('/update_course',[\App\Http\Controllers\CourseController::class, 'updateCourse'])->name('update_course');
Route::get('/course_details_view/{courseid}', [App\Http\Controllers\CourseController::class, 'courseDetails'])->name('detailsview');
Route::get('/view_course_banner/{id}',[\App\Http\Controllers\CourseController::class, 'viewBanner'])->name('view_banner');
Route::get('/view_course_document/{id}',[\App\Http\Controllers\CourseController::class, 'viewDocument'])->name('view_document');
Route::post('/course_view',[\App\Http\Controllers\CourseController::class, 'viewCourseDescription'])->name('course_view');

//Subject
Route::get('settings/view_subjects', [App\Http\Controllers\SubjectController::class, 'viewSubject'])->name('subject_list')->middleware('auth');
Route::post('/submit_subject', [App\Http\Controllers\SubjectController::class, 'submitSubject'])->name('submit_subject');
Route::any('/subjectStatus/{subjectid?}', [App\Http\Controllers\SubjectController::class, 'subjectStatus'])->name('subject_status');
Route::post('/edit_subject',[\App\Http\Controllers\SubjectController::class, 'editSubject'])->name('edit_subject');
Route::post('/update_subject',[\App\Http\Controllers\SubjectController::class, 'updateSubject'])->name('update_subject');
Route::post('/sub_view',[\App\Http\Controllers\SubjectController::class, 'viewSubjectDescription'])->name('sub_view');

//Course Subject Mapping

Route::get('settings/view_mapping', [App\Http\Controllers\SubjectController::class, 'viewMapping'])->name('mapping_list')->middleware('auth');

Route::post('/course_subject_mapping', [App\Http\Controllers\SubjectController::class, 'submitCousreSubjectMapping'])->name('submit_csmapping');
Route::any('/mappingStatus/{mappingid?}', [App\Http\Controllers\SubjectController::class, 'mappingStatus'])->name('mapping_status');
Route::post('/edit_mapping',[\App\Http\Controllers\SubjectController::class, 'editMapping'])->name('edit_mapping');
Route::post('/update_mapping',[\App\Http\Controllers\SubjectController::class, 'updateMapping'])->name('update_mapping');
Route::post('get_courses_maped',[\App\Http\Controllers\SubjectController::class, 'get_courses_maped'])->name('get_courses_maped');


//mycourses
Route::get('mycourses/index', [App\Http\Controllers\MycoursesController::class, 'index'])->name('mycourses_index')->middleware('auth');
Route::get('mycourses/course_detail/{id}',[\App\Http\Controllers\MycoursesController::class, 'course_detail'])->name('course_detail')->middleware('auth');
Route::post('mycourses/get_topic_detail',[\App\Http\Controllers\MycoursesController::class, 'get_topic_detail'])->name('get_topic_detail');
Route::post('mycourses/get_topic_question',[\App\Http\Controllers\MycoursesController::class, 'get_topic_question'])->name('get_topic_question');
Route::post('mycourses/add_video_link',[\App\Http\Controllers\MycoursesController::class, 'addVideoLink'])->name('add_video_link');
Route::post('mycourses/edit_video_link',[\App\Http\Controllers\MycoursesController::class, 'updateVideoLink'])->name('update_video_link');
Route::post('mycourses/add_content',[\App\Http\Controllers\MycoursesController::class, 'addContent'])->name('add_content');
Route::post('mycourses/update_content',[\App\Http\Controllers\MycoursesController::class, 'updateContent'])->name('update_content');
Route::post('mycourses/edit_content',[\App\Http\Controllers\MycoursesController::class, 'edit_content'])->name('edit_content');

Route::get('/view_mycourse_document/{id}',[\App\Http\Controllers\MycoursesController::class, 'viewDocument'])->name('view_document');
Route::post('mycourses/add_document',[\App\Http\Controllers\MycoursesController::class, 'addDocument'])->name('add_document');
Route::post('mycourses/edit_document',[\App\Http\Controllers\MycoursesController::class, 'updateDocument'])->name('update_document');
//mycourses - Questions
Route::post('mycourses/add_true_or_false',[\App\Http\Controllers\MycoursesController::class, 'addTrueOrFalse'])->name('add_true_or_false');
Route::post('mycourses/edit_true_or_false',[\App\Http\Controllers\MycoursesController::class, 'updateTrueOrFalse'])->name('update_true_or_false');
// Route::any('mycourses/tofStatus/{tofid?}', [App\Http\Controllers\MycoursesController::class, 'tofStatus'])->name('tof_status');
Route::post('mycourses/add_mcq',[\App\Http\Controllers\MycoursesController::class, 'addMcq'])->name('add_mcq');
Route::post('mycourses/edit_mcq',[\App\Http\Controllers\MycoursesController::class, 'updateMcq'])->name('update_mcq');
// Route::any('mycourses/mcqStatus/{mcqid?}', [App\Http\Controllers\MycoursesController::class, 'mcqStatus'])->name('mcq_status');

Route::get('settings/student_course_mapping', [App\Http\Controllers\studentCourseController::class, 'index'])->name('student_course_mapping')->middleware('auth');
Route::post('get_stud_courses_maped',[\App\Http\Controllers\studentCourseController::class, 'get_stud_courses_maped'])->name('get_stud_courses_maped');
//
Route::post('/submit_sudentmapping', [App\Http\Controllers\studentCourseController::class, 'submit_sudentmapping'])->name('submit_sudentmapping');
//
Route::any('/student_mappingStatus/{mappingid?}', [App\Http\Controllers\studentCourseController::class, 'mappingStatus'])->name('student_mappingStatus');
//


Route::post('/edit_student_mapping',[\App\Http\Controllers\studentCourseController::class, 'edit_student_mapping'])->name('edit_student_mapping');

});

//Subject Chapter Mapping

Route::get('settings/subject_chapter_mapping', [App\Http\Controllers\SubjectChapterController::class, 'index'])->name('subject_chapter_mapping')->middleware('auth');
Route::get('getsubject',[App\Http\Controllers\SubjectChapterController::class,'getSubject'])->name('get_subject');
Route::post('get_sub_chapter_maped',[\App\Http\Controllers\SubjectChapterController::class, 'get_sub_chapter_maped'])->name('get_sub_chapter_maped');
Route::post('/submit_chaptermapping', [App\Http\Controllers\SubjectChapterController::class, 'submit_chaptermapping'])->name('submit_chaptermapping');
Route::any('/subject_chapter_mappingStatus/{mappingid?}', [App\Http\Controllers\SubjectChapterController::class, 'mappingStatus'])->name('chapter_mappingStatus');
Route::post('/edit_chapter_mapping',[\App\Http\Controllers\SubjectChapterController::class, 'edit_chapter_mapping'])->name('edit_chapter_mapping');

