<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectChapterMapping;
use App\Models\Subject;
use App\Models\Chapter;
use Carbon\Carbon;
use Auth;

class SubjectChapterController extends Controller
{
    public function index()
    {
   		$mappings = SubjectChapterMapping::all();
        foreach($mappings as $map) 
        {
            $map->subject = Subject::where('id', $map->subject_id)->first();
            $map->chapter = Chapter::where('id', $map->chapter_id)->first();
        }
        $subjects = Subject::where('is_active', 1)->get();
        $chapters = Chapter::where('is_active', 1)->get();
        return view('settings.subject_chapter_mapping',compact('mappings','subjects','chapters'));
    }

    public function get_sub_chapter_maped(Request $request)
    {
        $subjectId =$request->subjectId;
        $mappingDetail = SubjectChapterMapping::where('subject_id',$subjectId)->where('is_active',1)->pluck('chapter_id')->toArray();
        return response()->json(['data'=>$mappingDetail]);
    }

    public function submit_chaptermapping(Request $request)
   {
   		$request->validate([
            'subject_id' => 'required',
            'chapter_id' => 'required',
        ]);

        $chapter_cnt = count($request->chapter_id);
        $chapters = $request->chapter_id;

        $chapter_ids = implode(',',$chapters);
        $delet_old = SubjectChapterMapping::where('subject_id',$request->subject_id)->pluck('chapter_id')->toArray();
        $del = array_diff($delet_old ,$chapters);
        
        if(!empty($del))
        {
            SubjectChapterMapping::where('subject_id',$request->subject_id)->whereIn('chapter_id',$del)->delete();
        }

        if($chapter_cnt > 0) 
        {
            foreach ($chapters as $k => $val) 
            {
               $new_chapter = $val;
                $check_mapping = SubjectChapterMapping::Where('subject_id','=',$request->subject_id)->where('chapter_id','=',$new_chapter)->first();
                if(!isset($check_mapping))
                {
                    $csmapping = SubjectChapterMapping::updateOrCreate(
                            [
                                'subject_id'=>$request->subject_id,
                                'added_by'    => Auth::user()->id,
                                'chapter_id'  => $new_chapter,
                               
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
}
