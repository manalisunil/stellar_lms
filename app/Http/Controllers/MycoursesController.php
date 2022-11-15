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
use App\Models\TopicVideo;
use App\Models\TopicContent;
use Carbon\Carbon;

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
		$id = $request->id;
		$topic = Topic::find($id);
		$videos = TopicVideo::where('topic_id', $topic->id)->where('is_active', 1)->get();
		$contents = TopicContent::where('topic_id', $topic->id)->where('is_active', 1)->get();
    	?>
    	<div class="col-md-12">
                    <div class="row  pr-4">
                        <button class="mx-1 btn btn-sm btn-primary" data-toggle="modal" data-id="<?php $topic->id ?>" data-target="#videoAddModal">Add Video Link</button>
                        <button class="mx-1 btn btn-sm btn-primary" data-toggle="modal" data-id="<?php $topic->id ?>" data-target="#documentAddModal">Add Document</button>
                        <button class="mx-1 btn btn-sm btn-primary" data-toggle="modal" data-id="<?php $topic->id ?>" data-target="#contentAddModal">Add Content</button>
                     </div>
                  </div>
                  <div class="col-md-12 p-2">
                     <div class="card">
                       <div class="card-header">
                        Video Links
                       </div>
                       <div class="card-body">
                         <blockquote class="blockquote mb-0">
							<?php foreach($videos as $video)
								{
									echo $video->video_link;
								}
							?>
                           <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                           <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer> -->
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
						 	<?php foreach($contents as $content)
								{
									echo preg_replace("/^<p.*?>/", "",$content->content);
								}
							?>
                           <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                           <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer> -->
                         </blockquote>
                       </div>
                     </div>
                 </div>
                 <?php
    }

    public function addVideoLink(Request $request)
	{
		$request->validate([
    		'video_link'  =>'required',
        ]);

        $video = new TopicVideo();
        $video->topic_id = 1;
		$video->video_link = $request->video_link;
		$video->is_active = isset($request->is_active) ? 1 : 0;
        $video->added_by = auth()->user()->id;
        $video->added_datetime = Carbon::now();
        $res = $video->save();
        if($res)
        {
        	return response()->json(['data'=>'success','msg'=>'Video Link Added Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
	}

	public function addContent(Request $request)
	{
		$request->validate([
    		'contentvalue'  =>'required',
        ]);

        $content = new TopicContent();
        $content->topic_id = 1;
		$content->content = $request->contentvalue;
		$content->is_active = isset($request->is_active) ? 1 : 0;
        $content->added_by = auth()->user()->id;
        $content->added_datetime = Carbon::now();
        $res = $content->save();
        if($res)
        {
        	return response()->json(['data'=>'success','msg'=>'Content Added Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
	}
}
