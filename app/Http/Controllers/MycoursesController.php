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
use App\Models\SubjectChapterMapping;
use App\Models\TopicVideo;
use App\Models\TopicContent;
use App\Models\TopicDocument;
use App\Models\MCQ;
use App\Models\TrueOrFalse;
use Carbon\Carbon;
use Redirect;

class MycoursesController extends Controller
{
	
    public function index()
    {
        $cources = Course::where('is_active',1)->get(); 
        $courses_subjects =[];
		$subject_chapters = SubjectChapterMapping::get();
		foreach($subject_chapters as $chptr) 
        {
            $chptr->chapter = Chapter::where('id', $chptr->chapter_id)->first();
        }
        $chapters = Chapter::where('is_active',1)->get();
        $topic = Topic::where('is_active',1)->get();
        $course_id = "";
        if( count($cources) > 0)
        {
       		$course_id = $cources[0]->id;
       		return Redirect::route('course_detail',array($course_id));
        }


    	return view('includes.mycourses',compact('course_id','cources','courses_subjects','chapters','subject_chapters','topic'));
    }
    public function course_detail($id)
    {
    	$cources = Course::where('is_active',1)->get(); 
    	$courses_subjects = CourseSubjectMapping::join('mdblms_subjects','mdblms_subjects.id','=','mdblms_course_subject_mapping.subject_id')->where('mdblms_course_subject_mapping.course_id',$id)->where('mdblms_course_subject_mapping.is_active',1)->where('mdblms_subjects.is_active',1)->select('mdblms_course_subject_mapping.*')->get();
        $chapters = Chapter::where('is_active',1)->get();
		$subject_chapters = SubjectChapterMapping::where('course_id',$id)->get();
		foreach($subject_chapters as $chptr) 
        {
            $chptr->chapter = Chapter::where('id', $chptr->chapter_id)->first();
        }
    	$topic = Topic::where('is_active',1)->get();
    	$course_id  = $id;
    	return view('includes.mycourses',compact('course_id','cources','courses_subjects','chapters','topic','subject_chapters'));

    }
    public function get_topic_detail(Request $request)
    {
		$id = $request->id;
		$topic = Topic::find($id);
		$videos = TopicVideo::where('topic_id', $topic->id)->where('is_active',1)->get();
		$contents = TopicContent::where('topic_id', $topic->id)->where('is_active',1)->get();
		$documents = TopicDocument::where('topic_id', $topic->id)->where('is_active',1)->get();
    	?>
    	<div class="col-md-12 row ">
    		<div class="col-md-6">
    			<label class="lbl">Topic Name </label>
    			<span class="lbl_text  ">:&nbsp;<strong> <?php echo $topic->topic_name;?></strong></span>
    		</div>
    		<div class="col-md-6">
    			<label class="lbl">Chapter Name</label>
    			<span  class="lbl_text">:&nbsp; <strong><?php echo $topic->getChapter['chapter_name'];?></strong></span>
    		</div>
    	</div>
      	<div class="row p-2">
      		<div class="col-md-6">
				<div class="card h-100">
					<div class="card-header">
							<b>Video Links</b>	
					</div>
					<div class="card-body" style="max-height:200px;overflow-y:auto;padding: 0px!important;">
						<table id="video_table" width="100%" class="table datatable">
							<thead><tr style="background-color: #8080801a;"><th>Name</th><th>Link</th><th></th></tr></thead>
							<?php foreach($videos as $video)
								{
									echo '<tr><td>'.$video->video_name.'</td><td>'.$video->video_link. '</td><td><span style="float:right;" id="edit_video'.$video->id.'" class="edit_icon ml-2" onclick="editVideo('.$video->id.')"  data-is-active="'.$video->is_active.'" data-video-link="'.$video->video_link.'"  data-video_name="'.$video->video_name.'"  data-topic-id="'.$topic->id.'"    data-toggle="modal" data-id="'.$video->id.'">
										<img class="menuicon tbl_editbtn" src="'.asset("app-assets/assets/images/edit.svg").'" >&nbsp;</span></td></tr>';
								}
							?>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
             	<div class="card h-100">
					<div class="card-header">
							<b>Documents</b>
					</div>
					<div class="card-body" style="max-height:200px;overflow-y:auto;">
						<div class="row row-cols-2 px-2" id="document_table">

							<?php foreach($documents as $document)
							{
								echo '<div class="col pb-2 border-bottom"><a onclick="viewDocument('.$document->id.')" style="cursor: pointer;">'.$document->doc_name.'</a><span id="edit_document'.$document->id.'" class="edit_icon ml-2" onclick="editDocument('.$document->id.')" data-is-active="'.$document->is_active.'" data-topic-id="'.$topic->id.'" data-toggle="modal" data-id="'.$document->id.'">
									<img class="menuicon tbl_editbtn" src="'.asset("app-assets/assets/images/edit.svg").'" >&nbsp;</span></div>';
							}
							?>
						</div>
					</div>
             	</div>
			</div>
         	<div class="col-md-12 mt-2">
            	<div class="card">
					<div class="card-header">
							<b>Content</b>
					</div>
					<div class="card-body" style="max-height:400px;overflow-y:auto;">
							<!-- <table id="content_table"> -->
							<div class="row">	
							<?php foreach($contents as $content)
								{
									echo '<div class="col-12  border-bottom"><span style="float:right;" id="edit_content'.$content->id.'" class="edit_icon ml-2" onclick="editContent('.$content->id.')" data-is-active="'.$content->is_active.'" data-topic-id="'.$topic->id.'" data-toggle="modal" data-id="'.$content->id.'" >
										<img class="menuicon tbl_editbtn" src="'.asset("app-assets/assets/images/edit.svg").'" >&nbsp;</span>'.$content->content.'</div>';
								}
							?>
						</div>
							<!-- </table> -->
					</div>
             	</div>
         	</div>
        </div>
    <?php
    }

    public function addVideoLink(Request $request)
	{
		$request->validate([
    		'video_link'  =>'required',
    		'thumbnail_img'=>'max:50'

        ],[
        	'thumbnail_img.max'=>'The :attribute must have a maximum length of :max'
        ]);

		if($request->file('thumbnail_img'))
        {
			$file = $request->file('thumbnail_img');      
			$imgs  = $file->openFile()->fread($file->getSize());
			// $doc_name = $file->getClientOriginalName();
			$img_type = $file->getMimeType();  
        } else {
            $imgs = NULL;
            $img_type = NULL;
        }

        $video = new TopicVideo();
        $video->topic_id = $request->topic_id;
        $video->video_link = $request->video_link;
        $video->video_name = $request->video_name;
        $video->thumbnail_img = $imgs;
        $video->img_type = $img_type;
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
        ],
		[
			'contentvalue.required'=>'Content field is required'
		]
    	);
		
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
        $request->validate([
          'topic_document'  =>'required',
        ]);

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
    		'thumbnail_img'=>'max:50'

        ],[
        	'thumbnail_img.max'=>'The Thumbnail image must have a maximum length of :max KB'
        ]);
        if($request->file('thumbnail_img'))
        {
			$file = $request->file('thumbnail_img');      
			$imgs  = $file->openFile()->fread($file->getSize());
			// $doc_name = $file->getClientOriginalName();
			$img_type = $file->getMimeType();  
        } else {
            $imgs = NULL;
            $img_type = NULL;
        }
        
		$id = $request->video_edit_id;
        $video = TopicVideo::find($id);
        $video->topic_id = $request->video_topic_id;
        $video->video_link = $request->video_link;
         $video->video_name = $request->video_name;
        $video->thumbnail_img = $imgs;
        $video->img_type = $img_type;
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

	public function edit_content(Request $request)
	{
		$id = $request->id;
		$topicContent = TopicContent::where('id',$id)->pluck('content')->first();
		// dd($topicContent);
		return response()->json(['data'=>$topicContent]);


	}

	public function updateContent(Request $request)
	{
		$request->validate([
          'contentValue'  =>'required',
        ],
		[
			'contentValue.required'=>'Content field is required'
		]
    	);

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

	public function viewDocument($id)
    {
        if(request()->ajax()) {
            $output="";
            $document = TopicDocument::findOrFail($id);
            if(!empty($document->doc)) {
                if($document->doc_type == "application/pdf")
                {
                    $output.='<div id="removeData">'.
                        '<center><iframe height="450" width="700" display="block" src="data:application/pdf;base64,'.base64_encode($document->doc).'"></iframe></center>'.
                    '</div>';
                } else {
                    $output.='<div id="removeData">'.
                        '<img src="data:image;base64,'.base64_encode($document->doc).'"  style="width:40%;height:auto;">'.
                    '</div>';
                }
            } else {
                $output.= '<div id="removeData">'.
                    '<p>No Document to Display!</p>'.
                '</div>';
            }
            return response()->json(['data' => $output]);
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
		$id = $request->id;
		$topic = Topic::find($id);
		$mcqs = MCQ::where('topic_id', $topic->id)->where('type_id',1)->where('is_active',1)->get();
		$tofs = MCQ::where('topic_id', $topic->id)->where('type_id',2)->where('is_active',1)->get();
		?>
		<div class="col-md-12 row ">
    		<div class="col-md-6">
    			<label class="lbl">Topic Name </label>
    			<span class="lbl_text">:&nbsp; <?php echo $topic->topic_name;?></span>
    		</div>
    		<div class="col-md-6">
    			<label class="lbl">Chapter Name</label>
    			<span  class="lbl_text">:&nbsp; <?php echo $topic->getChapter['chapter_name'];?></span>
    		</div>
    	</div>
		<div class="col-md-12 p-2">
			<div class="card">
				<div class="card-header">
					MCQ
				</div>
				<div class="card-body">
					<table id="mcq_table" class="table table-bordered mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Question</th>
								<th>Option 1</th>
								<th>Option 2</th>
								<th>Option 3</th>
								<th>Option 4</th>
								<th>Answer</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($mcqs as $k=>$mcq)
							{
								echo '<tr>
									<td>'.++$k.'</td>
									<td>'.$mcq->question.'</td>
									<td>'.$mcq->option_1.'</td>
									<td>'.$mcq->option_2.'</td>
									<td>'.$mcq->option_3.'</td>
									<td>'.$mcq->option_4.'</td>
									<td>'.$mcq->correct_answer.'</td>
									<td> 
										<span id="edit_mcq'.$mcq->id.'" class="edit_icon ml-2" onclick="editMcq('.$mcq->id.')" data-topic-id="'.$topic->id.'" data-toggle="modal" data-id="'.$mcq->id.'" data-question="'.$mcq->question.'" data-answer="'.$mcq->correct_answer.'" data-opt1="'.$mcq->option_1.'" data-opt2="'.$mcq->option_2.'" data-opt3="'.$mcq->option_3.'" data-opt4="'.$mcq->option_4.'" data-reason="'.$mcq->reason.'" data-tags="'.$mcq->tags.'" data-is-active="'.$mcq->is_active.'">
										<img class="menuicon tbl_editbtn" src="'.asset("app-assets/assets/images/edit.svg").'" >&nbsp;</span>
									</td>
								</tr>';	
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					True/false
				</div>
				<div class="card-body">
					<table id="tof_table" class="table table-bordered mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Question</th>
								<th>Answer</th>
								<th>Reason</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($tofs as $k=>$tof)
							{
								echo '<tr>
									<td>'.++$k.'</td>
									<td>'.$tof->question.'</td>
									<td>'.($tof->correct_answer==1 ? "True" : "False").'</td>
									<td>'.$tof->reason.'</td>
									<td> 
										<span id="edit_tof'.$tof->id.'" class="edit_icon ml-2" onclick="editTrueOrFalse('.$tof->id.')" data-topic-id="'.$topic->id.'" data-toggle="modal" data-id="'.$tof->id.'" data-question="'.$tof->question.'" data-answer="'.$tof->correct_answer.'" data-reason="'.$tof->reason.'" data-tags="'.$tof->tags.'" data-is-active="'.$tof->is_active.'">
										<img class="menuicon tbl_editbtn" src="'.asset("app-assets/assets/images/edit.svg").'" >&nbsp;</span>
									</td>
								</tr>';	
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php
    }

	public function addMcq(Request $request)
    {
        $request->validate([
			'question' =>'required',
			'opt1' =>'required',
			'opt2' =>'required',
			'opt3' =>'required',
			'opt4' =>'required',
			'answer' =>'required',
			'reason' =>'required',
        ]);

        $mcq = new MCQ();
        $mcq->topic_id = $request->topic_id;
        $mcq->type_id = $request->type_id;

        $mcq->question = $request->question;
		$mcq->option_1 = $request->opt1;
        $mcq->option_2 = $request->opt2;
        $mcq->option_3 = $request->opt3;
        $mcq->option_4 = $request->opt4;
		$mcq->correct_answer = $request->answer;
        $mcq->reason = $request->reason;
		$mcq->tags = $request->tags;
        $mcq->is_active = isset($request->is_active) ? 1 : 0;
        $mcq->added_by = auth()->user()->id;
		$mcq->updated_by = auth()->user()->id;
        $mcq->datetime = Carbon::now();
        $res = $mcq->save();
        if($res)
        {
          return response()->json(['data'=>'success','msg'=>'MCQ Questions Added Successfully!']);
        }
        else
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

	public function updateMcq(Request $request)
	{
		$request->validate([
			'question' =>'required',
			'opt1' =>'required',
			'opt2' =>'required',
			'opt3' =>'required',
			'opt4' =>'required',
			'answer' =>'required',
			'reason' =>'required',
        ]);

		$id = $request->mcq_edit_id;
		$mcq = MCQ::find($id);
		$mcq->topic_id = $request->mcq_topic_id;
		$mcq->type_id = $request->type_id;
		$mcq->question = $request->question;
		$mcq->option_1 = $request->opt1;
        $mcq->option_2 = $request->opt2;
        $mcq->option_3 = $request->opt3;
        $mcq->option_4 = $request->opt4;
		$mcq->correct_answer = $request->answer;
        $mcq->reason = $request->reason;
		$mcq->tags = $request->tags;
        $mcq->is_active = isset($request->is_active) ? 1 : 0;
        $mcq->added_by = auth()->user()->id;
		$mcq->updated_by = auth()->user()->id;
        $mcq->datetime = Carbon::now();
        $res = $mcq->save();
		if($res)
		{
		return response()->json(['data'=>'success','msg'=>'MCQ Questions Updated Successfully!']);
		}
		else 
		{
			return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
		}
	}

	public function addTrueOrFalse(Request $request)
    {
        $request->validate([
			'question' =>'required',
			'answer'  =>'required',
			'reason'  =>'required',
        ]);

  //       $tof = new TrueOrFalse();
  //       $tof->topic_id = $request->topic_id;
  //       $tof->question = $request->question;
		// $tof->correct_answer = $request->answer;
  //       $tof->reason = $request->reason;
		// $tof->tags = $request->tags;
  //       $tof->is_active = isset($request->is_active) ? 1 : 0;
  //       $tof->added_by = auth()->user()->id;
		// $tof->updated_by = auth()->user()->id;
  //       $tof->datetime = Carbon::now();
  //       $res = $tof->save();

        $mcq = new MCQ();
		$mcq->topic_id = $request->topic_id;
		$mcq->type_id = $request->type_id;
		$mcq->question = $request->question;
		$mcq->option_1 = 1;
        $mcq->option_2 = 2;
        $mcq->option_3 = NULL;
        $mcq->option_4 = NULL;
		$mcq->correct_answer = $request->answer;
        $mcq->reason = $request->reason;
		$mcq->tags = $request->tags;
        $mcq->is_active = isset($request->is_active) ? 1 : 0;
        $mcq->added_by = auth()->user()->id;
		$mcq->updated_by = auth()->user()->id;
        $mcq->datetime = Carbon::now();
        $res = $mcq->save();
        if($res)
        {
          return response()->json(['data'=>'success','msg'=>'True Or False Questions Added Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

	public function updateTrueOrFalse(Request $request)
	{
		$request->validate([
			'question' =>'required',
			'answer'  =>'required',
			'reason'  =>'required',
        ]);

		$id = $request->tof_edit_id;
		// $tof = TrueOrFalse::find($id);
		// $tof->topic_id = $request->tof_topic_id;
		// $tof->question = $request->question;
		// $tof->correct_answer = $request->answer;
  //       $tof->reason = $request->reason;
		// $tof->tags = $request->tags;
  //       $tof->is_active = isset($request->is_active) ? 1 : 0;
  //       $tof->added_by = auth()->user()->id;
		// $tof->updated_by = auth()->user()->id;
  //       $tof->datetime = Carbon::now();
  //       $res = $tof->save();
        $mcq =  MCQ::find($id);
		$mcq->topic_id = $request->tof_topic_id;
		$mcq->type_id = $request->type_id;
		$mcq->question = $request->question;
		$mcq->option_1 = 1;
        $mcq->option_2 = 2;
        $mcq->option_3 = NULL;
        $mcq->option_4 = NULL;
		$mcq->correct_answer = $request->answer;
        $mcq->reason = $request->reason;
		$mcq->tags = $request->tags;
        $mcq->is_active = isset($request->is_active) ? 1 : 0;
        // $mcq->added_by = auth()->user()->id;
		$mcq->updated_by = auth()->user()->id;
        $mcq->datetime = Carbon::now();
        $res = $mcq->save();
		if($res)
		{
		return response()->json(['data'=>'success','msg'=>'True Or False Questions Updated Successfully!']);
		}
		else 
		{
			return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
		}
	}

	public function mcqStatus($mcqid) 
    {
        $mcqdetails = MCQ::find($mcqid);
        if ($mcqdetails->is_active == 1) {
            MCQ::where('id', $mcqid)->update(['is_active' => 0]);
        } else {
            MCQ::where('id', $mcqid)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }

	public function tofStatus($tofid) 
    {
        $tofdetails = MCQ::find($tofid);
        if ($tofdetails->is_active == 1) {
            MCQ::where('id', $tofid)->update(['is_active' => 0]);
        } else {
            MCQ::where('id', $tofid)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }
}
