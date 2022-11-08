<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Course;
use Auth;

class CourseController extends Controller
{
    public function viewCourse()
    {
        $courses = Course::all();
        $company_list = Company::all();
        return view('course_list',compact('courses','company_list'));
    }

    public function submitCourse(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'company_id' => 'required',
            'course_name' => 'required',
            'course_description' => 'required',
            'course_duration' =>'required',
            'course_deliverables' => 'required',
            'course_eligibility' => 'required',
        ]);

        if($request->file('course_document'))
        {
            $file = $request->file('course_document');
            $document = $file->openFile()->fread($file->getSize());
            $document_type = $file->getMimeType(); 
        }
        else
        {
            $document = NULL;
            $document_type = NULL;
        }

        if($request->file('course_banner'))
        {
            $file = $request->file('course_banner');
            $banner = $file->openFile()->fread($file->getSize());
            $banner_type = $file->getMimeType(); 
        }
        else
        {
            $banner = NULL;
            $banner_type = NULL;
        }

        $course = new Course();
        $course->company_id = $request->company_id;
        $course->course_id = $request->course_id;
        $course->course_name = $request->course_name;
        $course->course_description = $request->course_description;
        $course->course_duration = $request->course_duration;
        $course->course_deliverables = $request->course_deliverables;
        $course->course_eligibility = $request->course_eligibility;
        $course->course_added_by = Auth::user()->id;
        $course->course_price = $request->course_price;
        $course->course_doc = $document;
        $course->course_doc_type = $document_type;
        $course->course_banner = $banner;
        $course->course_banner_type = $banner_type;
        $course->is_active = ($request->is_active == 1)? 1 :0;
        $course->course_added_datetime = date('Y-m-d H:i:s');
        if($course->save())
        {
            return response()->json(['data'=>'success','msg'=>'Course Added Successfully!']);
        }
        else
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

    public function courseStatus($courseid) 
    {
        $coursedetails = Course::find($courseid);
        if ($coursedetails->is_active == 1) {
            Course::where('id', $courseid)->update(['is_active' => 0]);
        } else {
            Course::where('id', $courseid)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }

        // public function editCourse(Request $request)
    // {
    //     $id =$request->id;
    //     $courseDetail = Course::where('id',$id)->get();
    //     return response()->json(['data'=>$courseDetail]);
    // }

    // public function updateCourse(Request $request)
    // {
    //      $request->validate([
    //          // 'course_id' => 'required',
                // 'company_id' => 'required',
                // 'course_name' => 'required',
                // 'course_description' => 'required',
                // 'course_duration' =>'required',
                // 'course_deliverables' => 'required',
                // 'course_eligibility' => 'required',
    //     ]);

    // if($request->file('course_document'))
    // {
    //     $file = $request->file('course_document');
    //     $document = $file->openFile()->fread($file->getSize());
    //     $document_type = $file->getMimeType(); 
    // }
    // else
    // {
    //     $document = NULL;
    //     $document_type = NULL;
    // }

    // if($request->file('course_banner'))
    // {
    //     $file = $request->file('course_banner');
    //     $banner = $file->openFile()->fread($file->getSize());
    //     $banner_type = $file->getMimeType(); 
    // }
    // else
    // {
    //     $banner = NULL;
    //     $banner_type = NULL;
    // }
        
    //     $course = Course::find($request->course_id);
    //     $course->company_id = $request->company_id;
        // $course->course_id = $request->course_id;
        // $course->course_name = $request->course_name;
        // $course->course_description = $request->course_description;
        // $course->course_duration = $request->course_duration;
        // $course->course_deliverables = $request->course_deliverables;
        // $course->course_eligibility = $request->course_eligibility;
        // $course->course_added_by = Auth::user()->id;
        // $course->course_price = $request->course_price;
        // $course->course_doc = $document;
        // $course->course_doc_type = $document_type;
        // $course->course_banner = $banner;
        // $course->course_banner_type = $banner_type;
        // $course->is_active = ($request->is_active == 1)? 1 :0;
        // $course->course_added_datetime = date('Y-m-d H:i:s');
        // $res = $course->save();
    //     if($res)
    //     {
    //         return response()->json(['data'=>'success','msg'=>'Course Updated Successfully!']);
    //     } 
    //     else 
    //     {
    //         return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
    //     }
    // }
}
