<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Chapter;
use Carbon\Carbon;

class ChapterController extends Controller
{
    public function index()
    {
    	// $subjectList  = Subject::where('is_active',1)->get();
        $chapterList  = Chapter::get();
        return view('settings.chapter',compact('chapterList'));
    }
    public function add_chapter(Request $request)
    {
    	$request->validate([
            'chapter_id' => 'required|unique:mdblms_chapters,chapter_id',
            'chapter_name' => 'required|unique:mdblms_chapters,chapter_name',
            'descriptionValue' => 'required',
        ]);

        $chapt = new Chapter();
        $chapt->chapter_id = $request->chapter_id;
        $chapt->chapter_name = $request->chapter_name;
        $chapt->chapter_description = $request->descriptionValue;
        $chapt->added_by = auth()->user()->id;
        $chapt->added_datetime = Carbon::now();
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
        // $subjectList  = Subject::where('is_active',1)->get();
        $chapterDetail = Chapter::where('id',$id)->first();
       	$output="";
       	$output .= '<div class="modal-body">
						<input type="hidden" name="id" id="id" value="'.$chapterDetail->id.'">
						<div class="row">
							<div class="col-lg-1 pr-0">
                                <label for="company_select" class="col-form-label"> Chapter Id <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
                                <input required name="chapter_id" value="'.$chapterDetail->chapter_id.'" id="chapter_id" type="text" class="form-control" placeholder="Enter Chapter Id" required  />
							</div>
							<div class="col-lg-1 pr-0">
								<label for="example-firstname-input" class="col-form-label">Chapter Name <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
                                <input required name="chapter_name" value="'.$chapterDetail->chapter_name.'" id="chapter_name" type="text" class="form-control" placeholder="Enter Chapter Name" required />
							</div>
                            <div class="col-lg-1 pr-0">
                                <label for="example-email-input" class="col-form-label pr-3">Status </label> 
                            </div>
                            <div class="col-lg-3 mt-3">
                                <input type="checkbox" class="" value="1" id="is_active" name="is_active"';
                                if ($chapterDetail->is_active == 1)
                                    $output.='checked';
                                else {
                                    $output.='';
                                }
                                $output .='/>
                            </div>
						</div>
                        <div class="row mt-2">
                            <div class="col-lg-1 pr-0">
                                <label for="example-email-input" class="col-form-label">Description <span class="text-danger"> * </span></label><br>
                            </div>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="chapter_description1" id="chapter_description1" required>'.$chapterDetail->chapter_description.'</textarea>
                            </div>	
                        </div>
					</div>';
		echo $output;
    }
    public function updateChapter(Request $request)
    {
    	$request->validate([
            'chapter_id' => 'required|unique:mdblms_chapters,chapter_id,'.$request->id,
            'chapter_name' => 'required|unique:mdblms_chapters,chapter_name,'.$request->id,
            'descriptionValue' => 'required'
        ]);

        $chapt = Chapter::find($request->id);
        $chapt->chapter_id = $request->chapter_id;
        $chapt->chapter_name = $request->chapter_name;
        $chapt->chapter_description = $request->descriptionValue;
        $chapt->added_by = auth()->user()->id;
        $chapt->added_datetime = Carbon::now();
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
    public function chapterstatus($id) 
    {
        $detail = Chapter::find($id);
        if ($detail->is_active == 1) 
        {
            Chapter::where('id', $id)->update(['is_active' => 0]);
        } else {
            Chapter::where('id', $id)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }
    public function view_topic(Request $request)
    {
        $id = $request->id;
        $detail = Chapter::find($id);

        $output ='<div class="row ">
            <div class="col-lg-9 text-left">
                <h5 class="modal-title pl-3" id="exampleModalLabel">
                    
                    <img class="mensuicon " src="'.asset('app-assets/assets/images/backs.png').'" style="width:1.3rem;height:1.3rem;margin-right: 10px; cursor:pointer;" onclick=backTo_tble()>
                    
                        '.$detail->chapter_name.'
                </h5>
            </div>
        </div>
        <div class="card  card_top_orenge" >
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-2">
                        <label for="city-input" class="">Chapter Description :</b> </label>
                    </div>
                    <div class="col-lg-12">
                       '.$detail->chapter_description.'
                    </div> 
                </div>  
            </div>
        </div>';
        echo $output;
    }
}
