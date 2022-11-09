<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'subject_id' => 'required',
            'subject_name' => 'required',
        ]);

        $subject = new Subject();
        $subject->subject_id = $request->subject_id;
        $subject->subject_name = $request->subject_name;
        $subject->subject_description = $request->subject_description;
        $subject->added_by = Auth::user()->id;
        $subject->is_active = ($request->is_active == 1)? 1 :0;
        $subject->added_datetime = date('Y-m-d H:i:s');
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
        $request->validate([
            'subject_id' => 'required',
            'course_id' => 'required',
        ]);

        $check_mapping = CourseSubjectMapping::Where('subject_id','=',$request->subject_id)->where('course_id','=',$request->course_id)->first();
        if(isset($check_mapping))
        {
            return response()->json(['data'=>'error','msg'=>'Mapping Already Exists!']);
        }

        $csmapping = new CourseSubjectMapping();
        $csmapping->subject_id = $request->subject_id;
        $csmapping->course_id = $request->course_id;
        $csmapping->added_by = Auth::user()->id;
        $csmapping->is_active = ($request->is_active == 1)? 1 :0;
        $csmapping->added_datetime = date('Y-m-d H:i:s');
        if($csmapping->save())
        {
            return response()->json(['data'=>'success','msg'=>'Mapping Added Successfully!']);
        }
        else
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
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
            'subject_id' => 'required',
            'subject_name' => 'required',
        ]);
        $subject = Subject::find($request->id);
        $subject->subject_id = $request->subject_id;
        $subject->subject_name = $request->subject_name;
        $subject->subject_description = $request->descriptionValue;
        $subject->added_by = Auth::user()->id;
        $subject->is_active = ($request->is_active == 1)? 1 :0;
        $subject->added_datetime = date('Y-m-d H:i:s');
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

        $check_mapping = CourseSubjectMapping::Where('subject_id','=',$request->subject_id)->where('course_id','=',$request->course_id)->first();
        if(isset($check_mapping))
        {
            return response()->json(['data'=>'error','msg'=>'Mapping Already Exists!']);
        }

        $csmapping = CourseSubjectMapping::find($request->id);
        $csmapping->subject_id = $request->subject_id;
        $csmapping->course_id = $request->course_id;
        $csmapping->added_by = Auth::user()->id;
        $csmapping->is_active = ($request->is_active == 1)? 1 :0;
        $csmapping->added_datetime = date('Y-m-d H:i:s');
        if($csmapping->save())
        {
            return response()->json(['data'=>'success','msg'=>'Mapping Updated Successfully!']);
        }
        else
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

}
