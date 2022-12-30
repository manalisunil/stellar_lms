<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function viewCompany()
    {
        $companies = Company::all();
        return view('settings.company_list',compact('companies'));
    }

    public function submitCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|unique:mdblms_company,company_name',
            'address' => 'required',
            'phone_no' =>'required|unique:mdblms_company,phone_no',
            'email_id' => 'required|unique:mdblms_company,email_id',
            'logo' => 'nullable|file|max:50|image|mimes:jpeg,jpg,svg,png',
        ]);

        if($request->file('logo'))
        {
            $file = $request->file('logo');
            $logo = $file->openFile()->fread($file->getSize());
            $logo_type = $file->getMimeType(); 
        }
        else
        {
            $logo = NULL;
            $logo_type = NULL;
        }

        $company = new Company();
        $company->company_name = $request->company_name;
        $company->address = $request->address;
        $company->phone_no = $request->phone_no;
        $company->email_id = $request->email_id;
        $company->logo = $logo;
        $company->logo_type = $logo_type;
        $company->is_active = ($request->is_active == 1)? 1 :0;
        if($company->save())
        {
            return response()->json(['data'=>'success','msg'=>'Company Added Successfully!']);
        }
        else
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

    public function editCompany($id)
    {
        if(request()->ajax()) {
            $output="";
            $companyData = Company::findOrFail($id);
            $output.='<div id="removeData">'.
                '<input type="hidden" name="id" id="id" value="'.$companyData->id.'">'.
                '<div class="row ">'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="unique-id-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Company Name<span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input name="company_name" id="ed_company_name" type="text" class="form-control" value="'.$companyData->company_name.'" placeholder="Enter Company Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[a-zA-Z 0-9\.\&\-\@\:\/\[\]\(\)\_]*$" />'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="address-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Address<span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<textarea name="address" id="ed_address" type="text" class="form-control" placeholder="Enter Company Address">'.$companyData->address.'</textarea>'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="address-input" class="col-form-label">Phone No<span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input data-parsley-type="number" data-parsley-trigger="change" data-parsley-minlength="10" 
                            data-parsley-maxlength="15" id="ed_phone_no" name="phone_no" type="text" class="form-control" value="'.$companyData->phone_no.'" autocomplete="off" placeholder="Enter Phone Number"  data-parsley-minlength-message="Number should be Minimum 10 digits"  data-parsley-maxlength-message="Number should be max 15 digits" data-parsley-trigger="keyup" data-parsley-trigger="focusout" >'.                    
                    '</div>'.
                '</div>'.
                '<div class="row mt-2">'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="city-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Email Id<span class="text-danger"> * <span></label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input name="email_id" id="ed_email_id" type="email" class="form-control" value="'.$companyData->email_id.'" placeholder="Enter Email Id" required data-parsley-type="email" data-parsley-trigger="keyup" data-parsley-trigger="focusout"/>'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="doc-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Logo</label>'.
                    '</div>'.
                    '<div class="col-lg-3">'.
                        '<input id="ed_logo" name="logo" type="file" class="form-control" accept="image/*" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg">'.
                    '</div>'.
                    '<div class="col-lg-1 pr-0">'.
                        '<label for="active-input" class="col-forwm-label">Is Active?</label>'.
                    '</div>'.
                    '<div class="col-lg-3 mt-2">'.
                        '<input type="checkbox" value="1" id="ed_is_active" name="is_active" ';
                        if ($companyData->is_active == 1)
                            $output.='checked';
                        else {
                            $output.='';
                        }
                        $output.='>'.
                    '</div>'.
                '</div>'.
            '</div><br />';
            return response()->json(['data' => $output]);
        }
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|unique:mdblms_company,company_name,'.$request->id,
            'address' => 'required',
            'phone_no' =>'required|unique:mdblms_company,phone_no,'.$request->id,
            'email_id' => 'required|email|unique:mdblms_company,email_id,'.$request->id,
            'logo' => 'nullable|file|max:50|image|mimes:jpeg,jpg,svg,png',
        ]);

        $company = Company::find($request->id);

        if($request->file('logo'))
        {
            $file = $request->file('logo');
            $logo = $file->openFile()->fread($file->getSize());
            $logo_type = $file->getMimeType(); 
            $company->logo = $logo;
            $company->logo_type = $logo_type;
        }
        
        $company->company_name = $request->company_name;
        $company->address = $request->address;
        $company->phone_no = $request->phone_no;
        $company->email_id = $request->email_id;
        $company->is_active = ($request->is_active == 1)? 1 :0;
        if($company->save())
        {
            return response()->json(['data'=>'success','msg'=>'Company Updated Successfully!']);
        } 
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }

    public function companyStatus($companyid) 
    {
        $companydetails = Company::find($companyid);
        if ($companydetails->is_active == 1) {
            Company::where('id', $companyid)->update(['is_active' => 0]);
        } else {
            Company::where('id', $companyid)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }
}
