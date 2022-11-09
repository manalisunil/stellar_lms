<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function index()
    {
        $chapterList  = Chapter::where('is_active',1)->get();
        $topicList    = Topic::get();
        return view('settings.topic',compact('topicList','chapterList'));
    }
    public function add_topic(Request $request)
    {
    	$request->validate([
    		'chapter_id'  =>'required',
            'topic_id' => 'required|unique:mdblms_topics,topic_id',
            'topic_name' => 'required|unique:mdblms_topics,topic_name'
            
        ]);

        $topic = new Topic();
        $topic->chapter_id = $request->chapter_id;
        $topic->topic_id = $request->topic_id;
        $topic->topic_name = $request->topic_name;
        $topic->topic_description = $request->topic_description;
        $topic->added_by = auth()->user()->id;
        $topic->added_datetime = \Carbon\Carbon::now();
        $topic->is_active = isset($request->is_active) ? 1 : 0;
        $res = $topic->save();
        if($res)
        {
        	return response()->json(['data'=>'success','msg'=>'Topic Added Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }


    }
     public function edit_topic(Request $request)
    {
        $id =$request->id;
        $chapterList  = Chapter::where('is_active',1)->get();

        $topicDetail = Topic::where('id',$id)->first();
       	$output="";
       	$output .= '<div class="modal-body">
						<input type="hidden" name="id" id="id" value="'.$topicDetail->id.'">
						<div class="row">
							<div class="col-lg-4">
								<label for="company_select" class="col-form-label"> Chapter  <span class="text-danger"> * </span></label>
								<select required class="form-control" name="chapter_id" id="chapter_id">
									<option value="">Select Chapter</option>';
									foreach($chapterList as $chpdt) 
									{
										$output.='<option value="'.$chpdt->id.'"';
										if($chpdt->id == $topicDetail->chapter_id) {
										$output.='selected="selected"';
										}
										$output.= '>'.$chpdt->chapter_name.'</option>';
									}
			$output .='</select>
								
							</div>
							<div class="col-lg-4">
								<label for="company_select" class="col-form-label"> Topic Id <span class="text-danger"> * </span></label>
								<input required name="topic_id" value="'.$topicDetail->topic_id.'" id="topic_id" type="text" class="form-control" placeholder="Enter Topic Id" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9][A-Za-z 0-9]*$" />
								
							</div>

							<div class="col-lg-4">
								<label for="example-firstname-input" class="col-form-label">Topic Name <span class="text-danger"> * </span></label>
								<input required name="topic_name" value="'.$topicDetail->topic_name.'" id="topic_name" type="text" class="form-control" placeholder="Enter Topic Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" />
							</div>
							
						</div>
						<div class="row mt-1">
							<div class="col-lg-12">
								<label for="example-email-input" class="col-form-label">Desacription </label><br>
								<textarea class="form-control" name="topic_description1" id="topic_description1" required>'.$topicDetail->topic_description.'</textarea>
							</div>	
							
							<div class="col-lg-3">
								<label for="example-email-input" class="col-form-label pr-3">Status </label> 
								<input type="checkbox" checked class="" value="1" id="is_active" name="is_active"';
								if ($topicDetail->is_active == 1)
			                    $output.='checked';
			                else {
			                    $output.='';
			                }
			                $output .='/>
							</div>
					</div>';
		echo $output;

    }
    public function updatetopic(Request $request)
    {
    	$request->validate([
    		'chapter_id'  =>'required',
            'topic_id' => 'required|unique:mdblms_topics,topic_id,'.$request->id,
            'topic_name' => 'required|unique:mdblms_topics,topic_name,'.$request->id
            
        ]);

        $topic = Topic::find($request->id);
        $topic->chapter_id = $request->chapter_id;
        $topic->topic_id = $request->topic_id;
        $topic->topic_name = $request->topic_name;
        $topic->topic_description = $request->topic_description1;
        $topic->added_by = auth()->user()->id;
        $topic->added_datetime = \Carbon\Carbon::now();
        $topic->is_active = isset($request->is_active) ? 1 : 0;
        $res = $topic->save();
        if($res)
        {
        	return response()->json(['data'=>'success','msg'=>'Topic Updated Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }
    public function topicStatus($id) 
    {
        $detail = Topic::find($id);
        if ($detail->is_active == 1) {
            Topic::where('id', $id)->update(['is_active' => 0]);
        } else {
            Topic::where('id', $id)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }
    public function view_topic(Request $request)
    {
        $id = $request->id;
        $detail = Topic::find($id);
        // dd($detail);

        $output ='<div class="row ">
            <div class="col-lg-9 text-left">
                <h5 class="modal-title pl-3" id="exampleModalLabel">
                    
                    <img class="mensuicon " src="'.asset('app-assets/assets/images/backs.png').'" style="width:1.3rem;height:1.3rem;margin-right: 10px; cursor:pointer;" onclick=backTo_tble()>
                    
                        '.$detail->topic_name.'
                </h5>
            </div>
            <div class="col-lg-3 pt-2">
                <label for="unique-id-input" class="">Chapter Name  : '.$detail->getChapter['chapter_name'].'</b></label>
            </div>
        </div>
        <div class="card  card_top_orenge" >
            <div class="card-body">
                <div class="row mb-2">
                <div class="col-lg-1">
                    <label for="city-input" class="">Topic Desacription :</b> </label>
                </div>
                    <div class="col-lg-12">
                       '.$detail->topic_description.'
                    </div> 
                </div>  
            </div>
        </div>';
        echo $output;
    }
}
