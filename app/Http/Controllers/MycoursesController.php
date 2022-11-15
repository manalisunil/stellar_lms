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
    public function get_topic_detail(Request $request)
    {
    	?>
    	<div class="col-md-12">
                     <div class="row  pr-4">
                        <button class="mx-1 btn btn-sm btn-primary">Add Video Link</button>
                        <button class="mx-1 btn btn-sm btn-primary">Add Document</button>
                        <button class="mx-1 btn btn-sm btn-primary">Add Content</button>
                     </div>
                  </div>
                  <div class="col-md-12 p-2   ">
                    
                     <div class="card">
                       <div class="card-header">
                        Video Links
                       </div>
                       <div class="card-body">
                         <blockquote class="blockquote mb-0">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                           <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                         </blockquote>
                       </div>
                     </div>
                     <div class="card">
                       <div class="card-header">
                         Documents
                       </div>
                       <div class="card-body">
                         <blockquote class="blockquote mb-0">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                           <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                         </blockquote>
                       </div>
                     </div>
                    <div class="card">
                       <div class="card-header">
                         Content
                       </div>
                       <div class="card-body">
                         <blockquote class="blockquote mb-0">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                           <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                         </blockquote>
                       </div>
                     </div>
                 </div>
                 <?php
    }
}
