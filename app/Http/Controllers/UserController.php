<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use App\Models\User;


class UserController extends Controller
{
     public function index()
    {
    	$userList  = User::with('getCompany')->whereNotIn('user_type_id',[1])->get();
        $companyList  = Company::where('is_active',1)->get();
        $usertypesList    = DB::table('mdblms_usertypes')->whereNotIn('id', [1])->orderBy('id', 'ASC')->get();
        $allcompanyList  = Company::get();
        
        return view('settings.user',compact('userList','companyList','usertypesList'));
    }
    public function adduser(Request $request)
    {
    	$request->validate([
            'company_id'=>'required',
            'first_name' => 'required',
            'email' => 'required|unique:mdblms_users,email',
            'password'=>'required',          
            'user_type_id' => 'required',
            'gender'=>'required'
        ]);
    	if(isset($request->dob))
    	{
    		$dob = $request->dob;
    		$newDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dob)->format('Y-m-d');
    	}
    	else
    	{
    		$newDate = NULL;
    	}
        
        $user_insert_data = [
        			'company_id'=>$request->company_id,
        			'user_type_id'=>$request->user_type_id,
        			'first_name'=>$request->first_name,
        			'middle_name'=>$request->middle_name,
        			'last_name'=>$request->last_name,
        			'gender'=>$request->gender,
        			'dob'=>$newDate,
        			'contact_no'=>$request->contact_no,
        			'email'=>$request->email,
        			'password'=>Hash::make($request->password),
        			'address_line1'=>$request->address_line1,
        			'address_line2'=>$request->address_line2,
        			'city'=>$request->city,
        			'state'=>$request->state,
        			'country'=>$request->country,
        			'zip'=>$request->zip,
        			'qualification'=>isset($request->qualification) ? $request->qualification : NULL,
        			'institution'=>isset($request->institution) ? $request->institution : NULL ,
        			'is_content_writer'=>isset($request->is_content_writer)? 1 : 0,
        			'is_active'=>isset($request->is_active) ? 1 : 0 ,
        			'added_datetime'=>\Carbon\Carbon::now()

         ];

        if(User::insert($user_insert_data))
        {
            return response()->json(['data'=>'success','msg'=>'User Added Successfully!']);
        } 
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }

    }
    public function edit_user(Request $request)
    {
        $id =$request->id;
        $userDetail = User::where('id',$id)->first();
        $companyList  = Company::where('is_active',1)->get();
        $usertypesList    = DB::table('mdblms_usertypes')->whereNotIn('id', [1])->orderBy('id', 'ASC')->get();


       	$output="";
        $output .='
					<div class="modal-body">
						<input type="hidden" name="id" id="id" value="'.$userDetail->id.'">
						<div class="row">
							<div class="col-lg-3">
								<label for="company_select" class="col-form-label"> Company <span class="text-danger"> * </span></label>
								<select required class="form-control" name="company_id" id="company_id">
									<option value="">Select Company</option>';
									foreach($companyList as $compDt) 
									{
										$output.='<option value="'.$compDt->id.'"';
										if($compDt->id == $userDetail->company_id) {
										$output.='selected="selected"';
										}
										$output.= '>'.$compDt->company_name.'</option>';
									}

							$output .='</select>
							</div>

							<div class="col-lg-3">
								<label for="example-firstname-input" class="col-form-label">First Name <span class="text-danger"> * </span></label>
								<input required name="first_name" value="'.$userDetail->first_name.'" id="first_name" type="text" class="form-control" placeholder="Enter First Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" />
							</div>
							<div class="col-lg-3">
								<label for="example-mname-input" class="col-form-label">Middel Name</label>
								<input autocomplete="off"  value="'.$userDetail->middle_name.'" name="middle_name" id="middle_name" type="text" class="form-control" placeholder="Enter Middle Name" data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>
							</div>
							<div class="col-lg-3">
								<label for="example-firstname-input" class="col-form-label">Last Name</label>
								<input autocomplete="off"  value="'.$userDetail->last_name.'" name="last_name" id="last_name" type="text" class="form-control" placeholder="Enter Last Name" data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-lg-3">
								<label for="company_select" class="col-form-label"> User Type <span class="text-danger"> * </span></label>
								<select required class="form-control user_type_change" name="user_type_id" id="ed_user_type_id">
									<option value="">Select User Type</option>';
								
									foreach($usertypesList as $userTy) 
									{
										$output.='<option value="'.$userTy->id.'"';
										if($userTy->id == $userDetail->user_type_id) {
										$output.='selected="selected"';
										}
										$output.= '>'.$userTy->user_type.'</option>';
									}
							$output.='</select>
							</div>
							<div class="col-lg-3">
	                            <label for="active-input" class="col-form-label">Gender </label>
	                            <div class="mt-2">
		                            <input type="radio" id="gender" name="gender" value="1"';
		                             if ($userDetail->gender == 1)
					                    $output.='checked';
					                else {
					                    $output.='';
					                }
				                $output.='>Male 
			                            <input type="radio" id="gender" name="gender" value="2"'
			                            ;
			                            if ($userDetail->gender == 2)
				                    $output.='checked';
				                else {
				                    $output.='';
				                }
			                $output.='>Female
	                        	</div>
                        	</div>
                        	<div class="col-lg-3">
		                        <label for="name-input" class="col-form-label">Contact Number<span class="text-danger">  <span></label>
								<input data-parsley-type="number" data-parsley-trigger="change" data-parsley-minlength="10" 
								data-parsley-maxlength="10" id="contact_no" name="contact_no" type="text" class="form-control" autocomplete="off" placeholder="Enter Contact Number" value="'.$userDetail->contact_no.'" >
		                	</div>
                        	<div class="col-lg-3">
                                <label for="active-input" class="col-form-label">Date of Birth </label>
                                    <input class="form-control date-picker" name="dob" id="dob" type="text" value="'.$userDetail->dob.'"/>
                            </div>
                            <div class="col-lg-3">
							    <label for="name-input" class="col-form-label">Address 1<span class="text-danger">  <span></label>
								<input id="address_line1" name="address_line1" type="text" class="form-control" autocomplete="off" placeholder="Enter Address" value="'.$userDetail->address_line1.'" >
							</div>
							 <div class="col-lg-3">
							    <label for="name-input" class="col-form-label">Address 2<span class="text-danger">  <span></label>
								<input id="address_line2" name="address_line2" type="text" class="form-control" autocomplete="off" placeholder="Enter Address" value="'.$userDetail->address_line2.'" >
							</div>
							<div class="col-lg-3">
								<label for="example-email-input" class="col-form-label">Email <span class="text-danger"> * </span></label>
								<input autocomplete="off" required value="'.$userDetail->email.'" name="email" id="email" type="email" class="form-control" placeholder="Enter Email"/>
							</div>
							
							<div class="col-lg-3">
								<label for="example-email-input" class="col-form-label"> New Password<span class="text-danger"> * </span> </label>
								
								<input id="password" name="password" type="text" class="form-control" autocomplete="off" 	placeholder="Enter Password"   data-parsley-minlength="8"
								data-parsley-errors-container=".errorspannewpassinput"
								
								data-parsley-uppercase="1"
								data-parsley-lowercase="1"
								data-parsley-number="1"
								data-parsley-special="1"
								>
								<span class="errorspannewpassinput" style="font-weight: 400;"></span>
							</div>
							<div class="col-lg-3">
		                        <label for="name-input" class="col-form-label">City<span class="text-danger"><span></label>
		                            <input id="city" name="city" type="text" class="form-control" autocomplete="off" placeholder="Enter City"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->city.'">
			                </div>
			                <div class="col-lg-3">
		                        <label for="name-input" class="col-form-label">State<span class="text-danger"><span></label>
		                            <input id="state" name="state" type="text" class="form-control" autocomplete="off" placeholder="Enter State"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->state.'">
			                </div>
			                <div class="col-lg-3">
		                        <label for="name-input" class="col-form-label">Country<span class="text-danger"><span></label>
		                            <input id="country" name="country" type="text" class="form-control" autocomplete="off" placeholder="Enter Country"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->country.'">
			                </div>
							<div class="col-lg-3">
								<label for="name-input" class="col-form-label">Zip<span class="text-danger"> <span></label>
									<input data-parsley-type="integer" data-parsley-trigger="keyup" id="zip" name="zip" type="text" class="form-control" autocomplete="off" placeholder="Enter Zipcode" data-parsley-type-message ="This value should be a valid number" value="'.$userDetail->zip.'">
							</div>
							<div class="col-lg-3 user_type_div">
								<label for="name-input" class="col-form-label">Qualification<span class="text-danger"> <span></label>
									 <input id="qualification" name="qualification" type="text" class="form-control" autocomplete="off" placeholder="Enter qualification"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->qualification.'">
							</div>
							<div class="col-lg-3 user_type_div">
								<label for="name-input" class="col-form-label">Institution<span class="text-danger"> <span></label>
									 <input id="institution" name="institution" type="text" class="form-control" autocomplete="off" placeholder="Enter institution"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->institution.'">
							</div>
							
			
						<div class="col-lg-3 tutor_div">
							<label for="example-email-input" class="col-form-label">Is Content Writer </label><br>
							<input type="checkbox"  value="1" id="is_content_writer" name="is_content_writer" ';
							 if ($userDetail->is_content_writer == 1)
			                    $output.='checked';
			                else {
			                    $output.='';
			                }
			                $output.='>
						</div>	
							
						<div class="col-lg-3">
							<label for="example-email-input" class="col-form-label">Status </label><br>
							<input type="checkbox" checked value="1" id="is_active" name="is_active"';
							if ($userDetail->is_active == 1)
			                    $output.='checked';
			                else {
			                    $output.='';
			                }
			                $output.='>
						</div>
							
							
						
					</div>
						';
       echo $output;
    }
    public function updateUser(Request $request)
    {
    	$request->validate([
            'company_id'=>'required',
            'first_name' => 'required',
            // 'email' => 'required|unique:mdblms_users,email,'.$request->id,
            // 'password'=>'required',          
            'user_type_id' => 'required',
            'gender'=>'required'
        ]);
    	if(isset($request->dob))
    	{
    		$dob = $request->dob;
    		$newDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dob)->format('Y-m-d');
    	}
    	else
    	{
    		$newDate = NULL;
    	}
        
        $user_update_data = [
        			'company_id'=>$request->company_id,
        			'user_type_id'=>$request->user_type_id,
        			'first_name'=>$request->first_name,
        			'middle_name'=>$request->middle_name,
        			'last_name'=>$request->last_name,
        			'gender'=>$request->gender,
        			'dob'=>$newDate,
        			'contact_no'=>$request->contact_no,
        			'email'=>$request->email,
        			'password'=>Hash::make($request->password),
        			'address_line1'=>$request->address_line1,
        			'address_line2'=>$request->address_line2,
        			'city'=>$request->city,
        			'state'=>$request->state,
        			'country'=>$request->country,
        			'zip'=>$request->zip,
        			'qualification'=>isset($request->qualification) ? $request->qualification : NULL,
        			'institution'=>isset($request->institution) ? $request->institution : NULL ,
        			'is_content_writer'=>isset($request->is_content_writer)? 1 : 0,
        			'is_active'=>isset($request->is_active) ? 1 : 0 ,
        			'added_datetime'=>\Carbon\Carbon::now()

         ];
        $res = User::where('id', $request->id)->update($user_update_data);
        // dd($res);
        if($res)
        {
            return response()->json(['data'=>'success','msg'=>'User Updated Successfully!']);
        } 
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }
}