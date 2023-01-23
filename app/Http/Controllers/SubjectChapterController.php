<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectChapterMapping;
use App\Models\CourseSubjectMapping;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Course;
use Carbon\Carbon;
use Auth;

class SubjectChapterController extends Controller
{
    public function index()
    {
   		$mappings = SubjectChapterMapping::all();
        foreach($mappings as $map) 
        {
            $map->course = Course::where('id', $map->course_id)->first();
            $map->subject = Subject::where('id', $map->subject_id)->first();
            $map->chapter = Chapter::where('id', $map->chapter_id)->first();
        }
        $courses = Course::where('is_active', 1)->get();
        $subjects = Subject::where('is_active', 1)->get();
        $chapters = Chapter::where('is_active', 1)->get();
        return view('settings.subject_chapter_mapping',compact('mappings','courses','subjects','chapters'));
    }

    public function get_sub_chapter_maped(Request $request)
    {
        $subjectId =$request->subjectId;
        $courseId =$request->courseId;
        $mappingDetail = SubjectChapterMapping::where('course_id',$courseId)->where('subject_id',$subjectId)->where('is_active',1)->pluck('chapter_id')->toArray();
        return response()->json(['data'=>$mappingDetail]);
    }

    public function submit_chaptermapping(Request $request)
   {
   		$request->validate([
            'course_id' => 'required',
            'subject_id' => 'required',
            'chapter_id' => 'required',
        ]);

        $chapter_cnt = count($request->chapter_id);
        $chapters = $request->chapter_id;

        $chapter_ids = implode(',',$chapters);
        $delet_old = SubjectChapterMapping::where('course_id','=',$request->course_id)->where('subject_id',$request->subject_id)->pluck('chapter_id')->toArray();
        $del = array_diff($delet_old ,$chapters);
        
        if(!empty($del))
        {
            SubjectChapterMapping::where('course_id','=',$request->course_id)->where('subject_id',$request->subject_id)->whereIn('chapter_id',$del)->delete();
        }

        if($chapter_cnt > 0) 
        {
            foreach ($chapters as $k => $val) 
            {
               $new_chapter = $val;
                $check_mapping = SubjectChapterMapping::where('course_id','=',$request->course_id)->where('subject_id','=',$request->subject_id)->where('chapter_id','=',$new_chapter)->first();
                if(!isset($check_mapping))
                {
                    $csmapping = SubjectChapterMapping::updateOrCreate(
                        [
                            'course_id' => $request->course_id,
                            'subject_id'=> $request->subject_id,
                            'added_by' => Auth::user()->id,
                            'chapter_id' => $new_chapter,
                        ],
                        [
                            'added_datetime'=>Carbon::now(),
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
       $mappingdetails = SubjectChapterMapping::find($mappingid);
       if ($mappingdetails->is_active == 1)
        {
            SubjectChapterMapping::where('id', $mappingid)->update(['is_active' => 0]);
       } else {
            SubjectChapterMapping::where('id', $mappingid)->update(['is_active' => 1]);
       }
       
       return redirect()->back()->with('success', "Status Changed Successfully!");
   }

   public function edit_chapter_mapping(Request $request)
   { 
       $id =$request->id;
       $mappingDetail = SubjectChapterMapping::where('id',$id)->get();
       return response()->json(['data'=>$mappingDetail]);
   }

   public function getSubject(Request $request)
   {
       $mapped_subjects= CourseSubjectMapping::where("course_id",$request->id)->where('is_active',1)->pluck('subject_id')->toArray();
       $subjects = Subject::select('id','subject_name')->whereIn("id",$mapped_subjects)->get();
       return json_encode($subjects);
   }
}
