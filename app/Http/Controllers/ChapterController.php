<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subjects;
use App\Models\Chapter;

class ChapterController extends Controller
{
    public function index()
    {
    	$subjectList  = Subjects::where('is_active',1)->get();
        $chapterList  = Chapter::get();
        return view('settings.chapter',compact('chapterList','subjectList'));
    }
    public function add_chapter(Request $request)
    {
    	$request->validate([
    		'subject_id'  =>'required',
            'chapter_id' => 'required|unique:mdblms_chapters,chapter_id',
            'chapter_name' => 'required|unique:mdblms_chapters,chapter_name'
            
        ]);

        $chapt = new Chapter();
        $chapt->subject_id = $request->subject_id;
        $chapt->chapter_id = $request->chapter_id;
        $chapt->chapter_name = $request->chapter_name;
        $chapt->chapter_description = $request->chapter_description;
        $chapt->added_by = auth()->user()->id;
        $chapt->added_datetime = \Carbon\Carbon::now();
        $chapt->is_active = isset($request->is_active) ? 1 : 0;
        $res = $chapt->save();
        if($res)
        {
        	return response()->json(['data'=>'success','msg'=>'Chapter Added Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }


    }
     public function edit_chapter(Request $request)
    {
        $id =$request->id;
        $subjectList  = Subjects::where('is_active',1)->get();

        $chapterDetail = Chapter::where('id',$id)->first();
       	$output="";
       	$output .= '<div class="modal-body">
						<input type="hidden" name="id" id="id" value="'.$chapterDetail->id.'">
						<div class="row">
							<div class="col-lg-4">
								<label for="company_select" class="col-form-label"> Subject  <span class="text-danger"> * </span></label>
								<select required class="form-control" name="subject_id" id="subject_id">
									<option value="">Select Subject</option>';
									foreach($subjectList as $subDt) 
									{
										$output.='<option value="'.$subDt->id.'"';
										if($subDt->id == $chapterDetail->subject_id) {
										$output.='selected="selected"';
										}
										$output.= '>'.$subDt->subject_name.'</option>';
									}
			$output .='</select>
								
							</div>
							<div class="col-lg-4">
								<label for="company_select" class="col-form-label"> Chapter Id <span class="text-danger"> * </span></label>
								<input required name="chapter_id" value="'.$chapterDetail->chapter_id.'" id="chapter_id" type="text" class="form-control" placeholder="Enter Chapter Id" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9][A-Za-z 0-9]*$" />
								
							</div>

							<div class="col-lg-4">
								<label for="example-firstname-input" class="col-form-label">Subject Name <span class="text-danger"> * </span></label>
								<input required name="chapter_name" value="'.$chapterDetail->chapter_name.'" id="chapter_name" type="text" class="form-control" placeholder="Enter Chapter Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" />
							</div>
							
						</div>
						<div class="row mt-1">
							<div class="col-lg-12">
								<label for="example-email-input" class="col-form-label">Desacription </label><br>
								<textarea class="form-control" name="chapter_description1" id="chapter_description1" required>'.$chapterDetail->chapter_description.'</textarea>
							</div>	
							
							<div class="col-lg-3">
								<label for="example-email-input" class="col-form-label pr-3">Status </label> 
								<input type="checkbox" checked class="" value="1" id="is_active" name="is_active"';
								if ($chapterDetail->is_active == 1)
			                    $output.='checked';
			                else {
			                    $output.='';
			                }
			                $output .='/>
							</div>
					</div>';
		echo $output;

    }
    public function updateChapter(Request $request)
    {
    	$request->validate([
    		'subject_id'  =>'required',
            'chapter_id' => 'required|unique:mdblms_chapters,chapter_id,'.$request->id,
            'chapter_name' => 'required|unique:mdblms_chapters,chapter_name,'.$request->id
            
        ]);

        $chapt = Chapter::find($request->id);
        $chapt->subject_id = $request->subject_id;
        $chapt->chapter_id = $request->chapter_id;
        $chapt->chapter_name = $request->chapter_name;
        $chapt->chapter_description = $request->chapter_description1;
        $chapt->added_by = auth()->user()->id;
        $chapt->added_datetime = \Carbon\Carbon::now();
        $chapt->is_active = isset($request->is_active) ? 1 : 0;
        $res = $chapt->save();
        if($res)
        {
        	return response()->json(['data'=>'success','msg'=>'Chapter Updated Successfully!']);
        }
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }
}
