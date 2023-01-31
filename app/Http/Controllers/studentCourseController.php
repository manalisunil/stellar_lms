<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Course_assignment;
use Auth;


class studentCourseController extends Controller
{
    
   public function index()
   {
        if(Auth::user()->user_type_id != 3)
        {
            $mappings = Course_assignment::all();
            foreach($mappings as $map) 
            {
                $map->user = User::where('id', $map->user_id)->first();
                $map->Course = Course::where('id', $map->course_id)->first();
            }
            $cources = Course::where('is_active', 1)->get();
            $students = User::where('user_type_id',4)->where('is_active', 1)->get();
            return view('settings.student_courses_mapping',compact('mappings','students','cources'));
        } else {
            return "Unauthorized Access!";
        }

   }
   public function get_stud_courses_maped(Request $request)
   {
   		$userId =$request->userId;
        $mappingDetail = Course_assignment::where('user_id',$userId)->where('is_active',1)->pluck('course_id')->toArray();
        return response()->json(['data'=>$mappingDetail]);
   }
   public function submit_sudentmapping(Request $request)
   {
   		$request->validate([
            'user_id' => 'required',
            'course_id' => 'required',
        ]);

        $course_cnt = count($request->course_id);
        $courses = $request->course_id;

        $course_ids = implode(',',$courses);
        $delet_old = Course_assignment::where('user_id',$request->user_id)->pluck('course_id')->toArray();
        $del = array_diff($delet_old ,$courses);
        
        if(!empty($del))
        {
            Course_assignment::where('user_id',$request->user_id)->whereIn('course_id',$del)->delete();
        }

        if($course_cnt > 0) 
        {
            foreach ($courses as $k => $val) 
            {
               $new_course = $val;
                $check_mapping = Course_assignment::Where('user_id','=',$request->user_id)->where('course_id','=',$new_course)->first();
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
                    $csmapping = Course_assignment::updateOrCreate(
                            [
                                'user_id'=>$request->user_id,
                                'added_by'    => Auth::user()->id,
                                'course_id'  => $new_course,
                               
                            ],
                            [
                                'added_datetime'=>Carbon::now(),
                                'course_start_date'=>Carbon::now(),
                                 'is_active'  => 1
                            ]
                        );
                }
            }
        }
        return response()->json(['data'=>'success','msg'=>'Mapping Updated Successfully!']);
   }
   public function mappingStatus($mappingid) 
    {
        $mappingdetails = Course_assignment::find($mappingid);
        if ($mappingdetails->is_active == 1)
         {
            Course_assignment::where('id', $mappingid)->update(['is_active' => 0]);
        } else {
            Course_assignment::where('id', $mappingid)->update(['is_active' => 1]);
        }
        
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }

    public function edit_student_mapping(Request $request)
    {
        $id =$request->id;
        $mappingDetail = Course_assignment::where('id',$id)->get();
        return response()->json(['data'=>$mappingDetail]);
    }


}
