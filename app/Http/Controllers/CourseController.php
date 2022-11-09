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
            'descriptionValue' => 'required',
            'course_duration' =>'required',
            'deliverableValue' => 'required',
            'eligibilityValue' => 'required',
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
        $course->course_description = $request->descriptionValue;
        $course->course_duration = $request->course_duration;
        $course->course_deliverables = $request->deliverableValue;
        $course->course_eligibility = $request->eligibilityValue;
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

    public function editCourse($id)
    {
        $companies = Company::where('is_active', '=', 1)->get();
        if(request()->ajax()) {
            $output="";
            $courseData = Course::findOrFail($id);
            $output.='<div id="removeData">'.
                '<input type="hidden" name="id" id="id" value="'.$courseData->id.'">'.
                '<div class="row ">'.
                    '<div class="col-lg-1">'.
                        '<label for="unique-id-input" class="col-form-label">Course Id<span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input name="course_id" id="ed_course_id" value="'.$courseData->course_id.'" type="text" class="form-control" placeholder="COURS-0001" required/>'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="name-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Company Name<span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<select required class="form-control" name="company_id" id="ed_company_id">'.
                            '<option value="">Select Company</option>';
                            foreach($companies as $company) {
                                $output.='<option value="'.$company->id.'"';
                                if($company->id == $courseData->company_id) {
                                $output.='selected="selected"';
                                }
                                $output.= '>'.$company->company_name.'</option>';
                                }
                                $output.='</select>'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="address-input" class="col-form-label">Course Name<span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input name="course_name" id="ed_course_name" type="text" class="form-control" value="'.$courseData->course_name.'" placeholder="Enter Course Name" required/>'.
                    '</div>'.
                '</div>'.
                '<div class="row">'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="city-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Course Duration <span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input name="course_duration" id="ed_course_duration" type="text" class="form-control" value="'.$courseData->course_duration.'" placeholder="Enter Course Duration" required/>'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="state-input" class="col-form-label">Course Price</label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input name="course_price" id="ed_course_price" type="text" class="form-control" placeholder="Enter Course Price" value="'.$courseData->course_price.'" data-parsley-trigger="keyup" data-parsley-type="number" />'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="doc-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Course Document </label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input id="ed_course_document" name="course_document" type="file" class="form-control" accept="image/*,.pdf" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg,pdf">'.
                    '</div>'.
                '</div>'.
                '<div class="row">'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="banner-input" class="col-form-label">Course Banner </label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input id="ed_course_banner" name="course_banner" type="file" class="form-control" accept="image/*" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg">'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="active-input" class="col-forwm-label">Is Active?</label>'.
                    '</div>'.
                    '<div class="col-lg-3 mt-2">'.
                        '<input type="checkbox" value="1" id="ed_is_active" name="is_active" ';
                        if ($courseData->is_active == 1)
                            $output.='checked';
                        else {
                            $output.='';
                        }
                        $output.='>'.
                    '</div>'.
                '</div>'.
                '<div class="row">'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Course Description <span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-10">'.
                        '<textarea name="course_description" id="ed_course_description" type="text" class="form-control" placeholder="Enter Course Description">'.$courseData->course_description.'</textarea>'.
                    '</div>'.
                '</div>'.
                '<div class="row mt-1">'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Course Deliverables <span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-10">'.
                        '<textarea name="course_deliverables" id="ed_course_deliverables" type="text" class="form-control" placeholder="Enter Course Deliverables">'.$courseData->course_deliverables.'</textarea>'.
                    '</div>'.
                '</div>'.
                '<div class="row mt-1">'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="desc-input">Course Eligibility <span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-10">'.
                        '<textarea name="course_eligibility" id="ed_course_eligibility" type="text" class="form-control" placeholder="Enter Course Eligibility">'.$courseData->course_eligibility.'</textarea>'.
                    '</div>'.
                '</div>'.
            '</div><br />';
            return response()->json(['data' => $output]);
        }
    }

    public function updateCourse(Request $request)
    {
         $request->validate([
            'course_id' => 'required',
            'company_id' => 'required',
            'course_name' => 'required',
            'course_duration' =>'required',
            'descriptionValue' => 'required',
            'deliverableValue' => 'required',
            'eligibilityValue' => 'required',
        ]);

        $course = Course::find($request->id);

        if($request->file('course_document'))
        {
            $file = $request->file('course_document');
            $document = $file->openFile()->fread($file->getSize());
            $document_type = $file->getMimeType(); 
            $course->course_doc = $document;
            $course->course_doc_type = $document_type;
        }

        if($request->file('course_banner'))
        {
            $file = $request->file('course_banner');
            $banner = $file->openFile()->fread($file->getSize());
            $banner_type = $file->getMimeType(); 
            $course->course_banner = $banner;
            $course->course_banner_type = $banner_type;
        }
        
        $course->company_id = $request->company_id;
        $course->course_id = $request->course_id;
        $course->course_name = $request->course_name;
        $course->course_description = $request->descriptionValue;
        $course->course_duration = $request->course_duration;
        $course->course_deliverables = $request->deliverableValue;
        $course->course_eligibility = $request->eligibilityValue;
        $course->course_added_by = Auth::user()->id;
        $course->course_price = $request->course_price;
        $course->is_active = ($request->is_active == 1)? 1 :0;
        $course->course_added_datetime = date('Y-m-d H:i:s');
        $res = $course->save();
        if($res)
        {
            return response()->json(['data'=>'success','msg'=>'Course Updated Successfully!']);
        } 
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }
}
