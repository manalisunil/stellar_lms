<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\User;
use App\Models\Company;
use App\Models\CourseSubjectMapping;

class MycoursesController extends Controller
{
    public function index()
    {
        $cources = Course::where('is_active',1)->get(); 
        $courses_subjects =[];
        $chapters = Chapter::where('is_active',1)->get();
        $topic = Topic::where('is_active',1)->get();
        $course_id = "";
    	return view('includes.mycourses',compact('course_id','cources','courses_subjects','chapters','topic'));
    }
    public function course_detail($id)
    {
    	$cources = Course::where('is_active',1)->get(); 
    	$courses_subjects = CourseSubjectMapping::where('course_id',$id)->get();
        $chapters = Chapter::where('is_active',1)->get();
    	$topic = Topic::where('is_active',1)->get();
    	$course_id  = $id;
    	return view('includes.mycourses',compact('course_id','cources','courses_subjects','chapters','topic'));

    }
}
