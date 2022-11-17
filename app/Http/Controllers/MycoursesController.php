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
use App\Models\TopicDocument;
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
		$videos = TopicVideo::where('topic_id', $topic->id)->get();
		$contents = TopicContent::where('topic_id', $topic->id)->get();
		$documents = TopicDocument::where('topic_id', $topic->id)->get();
    	?>
    	<div class="col-md-12">
                    <div class="row  pr-4">
                        <button class="mx-1 btn btn-sm btn-primary" id="video_id" data-toggle="modal" data-id="<?php echo $topic->id; ?>" data-target="#videoAddModal">Add Video Link</button>
                        <button class="mx-1 btn btn-sm btn-primary" id="doc_id" data-toggle="modal" data-id="<?php echo $topic->id; ?>" data-target="#documentAddModal">Add Document</button>
                        <button class="mx-1 btn btn-sm btn-primary" id="content_id" data-toggle="modal" data-id="<?php echo $topic->id; ?>" data-target="#contentAddModal">Add Content</button>
                     </div>
                  </div>
                  <div class="col-md-12 p-2">
                     <div class="card">
                       <div class="card-header">
                        	<b>Video Links</b>	
                       </div>
                       <div class="card-body">
                         <table id="video_table">
							<?php foreach($videos as $video)
								{
									echo '<tr>'.$video->video_link. '<span style="float:right;" id="edit_video'.$video->id.'" class="edit_icon ml-2" onclick="editVideo('.$video->id.')"  data-is-active="'.$video->is_active.'" data-video-link="'.$video->video_link.'" data-topic-id="'.$topic->id.'" data-toggle="modal" data-id="'.$video->id.'">
										<img class="menuicon tbl_editbtn" src="'.asset("app-assets/assets/images/edit.svg").'" >&nbsp;</span></tr></br>';
								}
							?>
                         </table>
                       </div>
                     </div>
                     <div class="card">
                       <div class="card-header">
                         	<b>Documents</b>
                       </div>
                       <div class="card-body">
					   		<table id="video_table">
							   <?php foreach($documents as $document)
								{
									echo '<tr>'.$document->doc_name.'<span id="edit_document'.$document->id.'" class="edit_icon ml-2" onclick="editDocument('.$document->id.')" data-is-active="'.$document->is_active.'" data-topic-id="'.$topic->id.'" data-toggle="modal" data-id="'.$document->id.'">
										<img class="menuicon tbl_editbtn" src="'.asset("app-assets/assets/images/edit.svg").'" >&nbsp;</span></tr>&nbsp;&nbsp;';
								}
								?>
                         	</table>
                       </div>
                     </div>
                    <div class="card">
                       <div class="card-header">
                         	<b>Content</b>
                       </div>
                       <div class="card-body">
					   		<table id="video_table">
							<?php foreach($contents as $content)
								{
									echo '<tr>'.$content->content.'<span style="float:right;" id="edit_content'.$content->id.'" class="edit_icon ml-2" onclick="editContent('.$content->id.')" data-is-active="'.$content->is_active.'" data-topic-id="'.$topic->id.'" data-toggle="modal" data-id="'.$content->id.'" data-content="'.$content->content.'">
										<img class="menuicon tbl_editbtn" src="'.asset("app-assets/assets/images/edit.svg").'" >&nbsp;</span></tr></br>';
								}
							?>
                         	</table>
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
        $video->topic_id = $request->topic_id;
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
        $content->topic_id = $request->topic_id;
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

    public function addDocument(Request $request)
    {
        // $request->validate([
        //   'topic_document'  =>'required',
        // ]);

        if($request->file('topic_document'))
        {
			$file = $request->file('topic_document');      
			$doc = $file->openFile()->fread($file->getSize());
			$doc_name = $file->getClientOriginalName();
			$doc_type = $file->getMimeType();  
        } else {
            $doc = NULL;
			$doc_name = NULL;
            $doc_type = NULL;
        }

        $document = new TopicDocument();
        $document->topic_id = $request->topic_id;
        $document->doc = $doc;
		$document->doc_name = $doc_name;
        $document->doc_type = $doc_type;
        $document->is_active = isset($request->is_active) ? 1 : 0;
        $document->added_by = auth()->user()->id;
        $document->added_datetime = Carbon::now();
        $res = $document->save();
        if($res)
        {
          return response()->json(['data'=>'success','msg'=>'Document Added Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

	public function updateVideoLink(Request $request)
	{
		$request->validate([
    		'video_link'  =>'required',
        ]);
		$id = $request->video_edit_id;
        $video = TopicVideo::find($id);
        $video->topic_id = $request->video_topic_id;
        $video->video_link = $request->video_link;
        $video->is_active = isset($request->is_active) ? 1 : 0;
        $video->added_by = auth()->user()->id;
        $video->added_datetime = Carbon::now();
        $res = $video->save();
        if($res)
        {
        	return response()->json(['data'=>'success','msg'=>'Video Link Updated Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
	}

	public function updateContent(Request $request)
	{
		$request->validate([
			'contentValue'  =>'required',
		]);

		$id = $request->content_edit_id;
		$content = TopicContent::find($id);
		$content->topic_id = $request->content_topic_id;
		$content->content = $request->contentValue;
		$content->is_active = isset($request->is_active) ? 1 : 0;
		$content->added_by = auth()->user()->id;
		$content->added_datetime = Carbon::now();
		$res = $content->save();
		if($res)
		{
		return response()->json(['data'=>'success','msg'=>'Content Updated Successfully!']);
		}
		else 
		{
			return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
		}
	}

	public function updateDocument(Request $request)
	{
		$id = $request->doc_edit_id;
		$document = TopicDocument::find($id);
		if($request->file('topic_document') != NULL)
		{
			$file = $request->file('topic_document');      
			$doc = $file->openFile()->fread($file->getSize());
			$doc_name = $file->getClientOriginalName();
			$doc_type = $file->getMimeType(); 
			$document->doc = $doc;
			$document->doc_name = $doc_name;
			$document->doc_type = $doc_type; 
		} 
		$document->topic_id = $request->doc_topic_id;
		$document->is_active = isset($request->is_active) ? 1 : 0;
		$document->added_by = auth()->user()->id;
		$document->added_datetime = Carbon::now();
		$res = $document->save();
		if($res)
		{
		return response()->json(['data'=>'success','msg'=>'Document Updated Successfully!']);
		}
		else 
		{
			return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
		}
	}
   public function get_topic_question(Request $request)
    {
      ?>
      <div class="col-md-12">
       <div class="row  pr-4">
          <button class="mx-1 btn btn-sm btn-primary">ADD MCQ</button>
          <button class="mx-1 btn btn-sm btn-primary">Add True/False</button>
       </div>
      </div>
      <div class="col-md-12 p-2   ">

       <div class="card">
         <div class="card-header">
          MCQ
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
           True/false
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
