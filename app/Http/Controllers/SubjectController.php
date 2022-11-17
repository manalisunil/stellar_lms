<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Subject;
use App\Models\Course;
use App\Models\CourseSubjectMapping;
use Auth;

class SubjectController extends Controller
{
    
    public function viewSubject()
    {
        $subjects = Subject::all();
        return view('settings.subject_list',compact('subjects'));
    }

    public function submitSubject(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|unique:mdblms_subjects,subject_id',
            'subject_name' => 'required|unique:mdblms_subjects,subject_name',
        ]);

        $subject = new Subject();
        $subject->subject_id = $request->subject_id;
        $subject->subject_name = $request->subject_name;
        $subject->subject_description = $request->descriptionValue;
        $subject->added_by = Auth::user()->id;
        $subject->is_active = ($request->is_active == 1)? 1 :0;
        $subject->added_datetime = Carbon::now();
        if($subject->save())
        {
            return response()->json(['data'=>'success','msg'=>'Subject Added Successfully!']);
        }
        else
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

    public function subjectStatus($subjectid) 
    {
        $subjectdetails = Subject::find($subjectid);
        if ($subjectdetails->is_active == 1) {
            Subject::where('id', $subjectid)->update(['is_active' => 0]);
        } else {
            Subject::where('id', $subjectid)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }

    public function viewMapping()
    {
        $mappings = CourseSubjectMapping::all();
        foreach($mappings as $map) 
        {
            $map->course = Course::where('id', $map->course_id)->first();
            $map->subject = Subject::where('id', $map->subject_id)->first();
        }
        $cources = Course::where('is_active', 1)->get();
        $subjects = Subject::where('is_active', 1)->get();

        return view('settings.course_subject_mapping_list',compact('mappings','cources','subjects'));
    }

    public function submitCousreSubjectMapping(Request $request)
    {
        // dd($request);
        $request->validate([
            'subject_id' => 'required',
            'course_id' => 'required',
        ]);

        $course_cnt = count($request->subject_id);
        $courses = $request->subject_id;

        $course_ids = implode(',',$courses);
        // dd($courses);
        $delet_old = CourseSubjectMapping::where('course_id',$request->course_id)->pluck('subject_id')->toArray();
        $del = array_diff($delet_old ,$courses);
        // dd($del);
        
        if(!empty($del))
        {
            CourseSubjectMapping::where('course_id',$request->course_id)->whereIn('subject_id',$del)->delete();
        }

        if($course_cnt > 0) 
        {
            foreach ($courses as $k => $val) 
            {
               $new_course = $val;
                $check_mapping = CourseSubjectMapping::Where('course_id','=',$request->course_id)->where('subject_id','=',$new_course)->first();
                if(!isset($check_mapping))
                {
                    // $csmapping = new CourseSubjectMapping();
                    // $csmapping->subject_id = $request->subject_id;
                    // $csmapping->course_id = $new_course;
                    // $csmapping->added_by = Auth::user()->id;
                    // $csmapping->is_active = ($request->is_active == 1)? 1 :0;
                    // $csmapping->added_datetime = Carbon::now();
                    // $res =  $csmapping->save();
                    // DB::enableQueryLog();
                    $csmapping = CourseSubjectMapping::updateOrCreate(
                            [
                                'course_id'=>$request->course_id,
                                'added_by'    => Auth::user()->id,
                                'subject_id'  => $new_course,
                               
                            ],
                            [
                                'added_datetime'=>Carbon::now(),
                                 'is_active'  => 1
                            ]
                        );
                    // dd(DB::getQueryLog());

                }

               
            }
            

        }
            return response()->json(['data'=>'success','msg'=>'Mapping Added Successfully!']);
            
        // if($csmapping)
        // {
            // return response()->json(['data'=>'success','msg'=>'Mapping Added Successfully!']);
        // }
        // else
        // {
        //     return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        // }
    }

    public function mappingStatus($mappingid) 
    {
        $mappingdetails = CourseSubjectMapping::find($mappingid);
        if ($mappingdetails->is_active == 1) {
            CourseSubjectMapping::where('id', $mappingid)->update(['is_active' => 0]);
        } else {
            CourseSubjectMapping::where('id', $mappingid)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }

    public function editSubject(Request $request)
    {
        $id =$request->id;
        $subjectDetail = Subject::where('id',$id)->get();
        return response()->json(['data'=>$subjectDetail]);
    }

    public function updateSubject(Request $request)
    {
         $request->validate([
            'subject_id' => 'required|unique:mdblms_subjects,subject_id,'.$request->id,
            'subject_name' => 'required|unique:mdblms_subjects,subject_name,'.$request->id,
        ]);
        $subject = Subject::find($request->id);
        $subject->subject_id = $request->subject_id;
        $subject->subject_name = $request->subject_name;
        $subject->subject_description = $request->descriptionValue;
        $subject->added_by = Auth::user()->id;
        $subject->is_active = ($request->is_active == 1)? 1 :0;
        $subject->added_datetime = Carbon::now();
        $res = $subject->save();
        if($res)
        {
            return response()->json(['data'=>'success','msg'=>'Subject Updated Successfully!']);
        } 
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

    public function editMapping(Request $request)
    {
        $id =$request->id;
        $mappingDetail = CourseSubjectMapping::where('id',$id)->get();
        return response()->json(['data'=>$mappingDetail]);
    }

    public function updateMapping(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'course_id' => 'required',
        ]);


        $check_mapping = CourseSubjectMapping::Where('subject_id','=',$request->subject_id)->where('course_id','=',$request->course_id)->where('id','!=',$request->id)->first();

        if(isset($check_mapping))
        {
            return response()->json(['data'=>'error','msg'=>'Mapping Already Exists!']);
        }

        $csmapping = CourseSubjectMapping::find($request->id);
        $csmapping->subject_id = $request->subject_id;
        $csmapping->course_id = $request->course_id;
        $csmapping->added_by = Auth::user()->id;
        $csmapping->is_active = ($request->is_active == 1)? 1 :0;
        $csmapping->added_datetime = Carbon::now();
        if($csmapping->save())
        {
            return response()->json(['data'=>'success','msg'=>'Mapping Updated Successfully!']);
        }
        else
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

    public function viewSubjectDescription(Request $request)
    {
        $id = $request->id;
        $detail = Subject::find($id);
        $output ='<div class="row ">
            <div class="col-lg-9 text-left">
                <h5 class="modal-title pl-3" id="exampleModalLabel">
                    <img class="mensuicon " src="'.asset('app-assets/assets/images/backs.png').'" style="width:1.3rem;height:1.3rem;margin-right: 10px; cursor:pointer;" onclick=backTo_tble()>
                    
                        '.$detail->subject_name.'
                </h5>
            </div>
        </div>
        <div class="card  card_top_orenge" >
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-2">
                        <label for="city-input" class="">Subject Description :</b> </label>
                    </div>
                    <div class="col-lg-12">
                       '.$detail->subject_description.'
                    </div> 
                </div>  
            </div>
        </div>';
        echo $output;
    }
    
    public function get_courses_maped(Request $request)
    {
        $sub_id =$request->sub_id;
        $mappingDetail = CourseSubjectMapping::where('course_id',$sub_id)->pluck('subject_id')->toArray();
        return response()->json(['data'=>$mappingDetail]);
    }
}
