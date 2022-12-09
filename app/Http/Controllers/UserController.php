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
    	// DB::enableQueryLog();
    	$userList  = User::with('getCompany')->whereNotIn('user_type_id',[1])->get();
    	// dd(DB::getQueryLog());
        $companyList  = Company::where('is_active',1)->get();
        $usertypesList    = DB::table('mdblms_usertypes')->whereNotIn('id', [1])->orderBy('id', 'ASC')->get();
        $allcompanyList  = Company::get();
        
        return view('settings.user',compact('userList','companyList','usertypesList'));
    }
    public function adduser(Request $request)
    {
		$dt = new Carbon();
		$before = $dt->subYears(18)->format('Y-m-d');

    	$request->validate([
            'company_id'=>'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:mdblms_users,email',
            'password'=>'required',          
            'user_type_id' => 'required',
            'gender'=>'required',
			// 'dob' => 'nullable|before:' .$before
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
        			'added_datetime'=>Carbon::now()

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
        if($userDetail->dob != NULL)
        {

      
        	 $dob_date  = \Carbon\Carbon::parse($userDetail->dob)->format('d-m-Y');
        }
        else
        {
        	 $dob_date  = NULL;
        }
        
       	$output="";
        $output .='
					<div class="modal-body">
						<input type="hidden" name="id" id="id" value="'.$userDetail->id.'">
						<div class="row">
							<div class="col-lg-1 pr-0">
								<label for="company_select" class="col-form-label"> Company <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
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
							<div class="col-lg-1 pr-0">
								<label for="example-firstname-input" class="col-form-label">First Name <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
								<input required name="first_name" value="'.$userDetail->first_name.'" id="first_name" type="text" class="form-control" placeholder="Enter First Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" />
							</div>
							<div class="col-lg-1 pr-0">
								<label for="example-mname-input" class="col-form-label">Middle Name</label>
							</div>
							<div class="col-lg-3">
								<input autocomplete="off"  value="'.$userDetail->middle_name.'" name="middle_name" id="middle_name" type="text" class="form-control" placeholder="Enter Middle Name" data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-lg-1 pr-0">
								<label for="example-firstname-input" class="col-form-label">Last Name</label>
							</div>
							<div class="col-lg-3">
								<input autocomplete="off"  value="'.$userDetail->last_name.'" name="last_name" id="last_name" type="text" class="form-control" placeholder="Enter Last Name" data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>
							</div>
							<div class="col-lg-1 pr-0">
								<label for="company_select" class="col-form-label"> User Type <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
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
							<div class="col-lg-1 pr-0">
								<label for="active-input" class="col-form-label">Gender </label>
							</div>
							<div class="col-lg-3">
	                            <div class="mt-2">
		                            <input type="radio" id="gender" name="gender" value="1"';
		                             if ($userDetail->gender == 1)
					                    $output.='checked';
					                else {
					                    $output.='';
					                }
				                	$output.='>Male <input type="radio" id="gender" name="gender" value="0"';
			                            if ($userDetail->gender == 0)
											$output.='checked';
										else {
											$output.='';
										}
			                		$output.='>Female
	                        	</div>
                        	</div>
						</div>
						<div class="row mt-1">
							<div class="col-lg-1 pr-0">
								<label for="name-input" class="col-form-label">Contact Number<span class="text-danger">  <span></label>
							</div>
                        	<div class="col-lg-3">
								<input data-parsley-type="number" data-parsley-trigger="change" data-parsley-minlength="10" 
								data-parsley-maxlength="10" id="contact_no" name="contact_no" type="text" class="form-control" autocomplete="off" placeholder="Enter Contact Number" value="'.$userDetail->contact_no.'" >
		                	</div>
							<div class="col-lg-1 pr-0">
								<label for="active-input" class="col-form-label">Date of Birth </label>
							</div>
                        	<div class="col-lg-3">
                                <input class="form-control date-picker" name="dob" id="eddob" type="text" value="'.$dob_date.'" class="js-validate-dob" data-parsley-minimumage="15" 
							data-parsley-minimumage-message="Applicant must be at least 15 years of age to apply" data-parsley-validdate="" data-parsley-validdate-message="Please enter a valid date" data-parsley-pattern="/[0-9]\d*/"
	 						data-parsley-pattern-message="Only numbers allowed"    ata-parsley-validation-threshold="0" />
                            </div>
							<div class="col-lg-1 pr-0">
								<label for="name-input" class="col-form-label">Address 1<span class="text-danger">  <span></label>
							</div>
                            <div class="col-lg-3">
								<input id="address_line1" name="address_line1" type="text" class="form-control" autocomplete="off" placeholder="Enter Address" value="'.$userDetail->address_line1.'" >
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-lg-1 pr-0">
								<label for="name-input" class="col-form-label">Address 2<span class="text-danger">  <span></label>
							</div>
							 <div class="col-lg-3">
								<input id="address_line2" name="address_line2" type="text" class="form-control" autocomplete="off" placeholder="Enter Address" value="'.$userDetail->address_line2.'" >
							</div>
							<div class="col-lg-1 pr-0">
								<label for="example-email-input" class="col-form-label">Email <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
								<input autocomplete="off" required value="'.$userDetail->email.'" name="email" id="email" type="email" class="form-control" placeholder="Enter Email"/>
							</div>
							<div class="col-lg-1 pr-0">
								<label for="example-email-input" class="col-form-label"> New Password<span class="text-danger"> * </span> </label>
							</div>
							<div class="col-lg-3">
								<input id="password" name="password" type="text" class="form-control" autocomplete="off" 	placeholder="Enter Password"   data-parsley-minlength="8"
								data-parsley-errors-container=".errorspannewpassinput"
								data-parsley-uppercase="1"
								data-parsley-lowercase="1"
								data-parsley-number="1"
								data-parsley-special="1"
								>
								<span class="errorspannewpassinput" style="font-weight: 400;"></span>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-lg-1 pr-0">
								<label for="name-input" class="col-form-label">City<span class="text-danger"><span></label>
							</div>
							<div class="col-lg-3">
		                        <input id="city" name="city" type="text" class="form-control" autocomplete="off" placeholder="Enter City"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->city.'">
			                </div>
							<div class="col-lg-1 pr-0">
								<label for="name-input" class="col-form-label">State<span class="text-danger"><span></label>
							</div>
			                <div class="col-lg-3">
		                        <input id="state" name="state" type="text" class="form-control" autocomplete="off" placeholder="Enter State"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->state.'">
			                </div>
							<div class="col-lg-1 pr-0">
								<label for="name-input" class="col-form-label">Country<span class="text-danger"><span></label>
							</div>
			                <div class="col-lg-3">
		                        <input id="country" name="country" type="text" class="form-control" autocomplete="off" placeholder="Enter Country"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->country.'">
			                </div>
						</div>
						<div class="row mt-1">
							<div class="col-lg-1 pr-0">
								<label for="name-input" class="col-form-label">Zip<span class="text-danger"><span></label>
							</div>
							<div class="col-lg-3">
								<input data-parsley-type="integer" data-parsley-trigger="keyup" id="zip" name="zip" type="text" class="form-control" autocomplete="off" placeholder="Enter Zipcode" data-parsley-type-message ="This value should be a valid number" value="'.$userDetail->zip.'">
							</div>
							<div class="col-lg-1 pr-0 user_type_div">
								<label for="name-input" class="col-form-label">Qualification<span class="text-danger"> <span></label>
							</div>
							<div class="col-lg-3 user_type_div">
								<input id="qualification" name="qualification" type="text" class="form-control" autocomplete="off" placeholder="Enter qualification"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->qualification.'">
							</div>
							<div class="col-lg-1 pr-0 user_type_div">
								<label for="name-input" class="col-form-label">Institution<span class="text-danger"> <span></label>
							</div>
							<div class="col-lg-3 user_type_div">
								<input id="institution" name="institution" type="text" class="form-control" autocomplete="off" placeholder="Enter institution"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="'.$userDetail->institution.'">
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-lg-1 pr-0 tutor_div">
								<label for="example-email-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Is Content Writer </label><br>
							</div>
							<div class="col-lg-3 mt-3 tutor_div">
								<input type="checkbox"  value="1" id="is_content_writer" name="is_content_writer" ';
								if ($userDetail->is_content_writer == 1)
									$output.='checked';
								else {
									$output.='';
								}
								$output.='>
							</div>
							<div class="col-lg-1 pr-0">
								<label for="example-email-input" class="col-form-label">Status </label><br>
							</div>	
							<div class="col-lg-3 mt-3">
								<input type="checkbox" value="1" id="is_active" name="is_active"';
								if ($userDetail->is_active == 1)
									$output.='checked';
								else {
									$output.='';
								}
								$output.='>
							</div>
						</div>
					</div>';
       echo $output;
    }
    public function updateUser(Request $request)
    {
		$dt = new Carbon();
		$before = $dt->subYears(18)->format('Y-m-d');

    	$request->validate([
            'company_id'=>'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:mdblms_users,email,'.$request->id,
            'user_type_id' => 'required',
            'gender'=>'required',
			// 'dob' => 'nullable|before:' .$before
        ]);
    	if(isset($request->dob))
    	{
    		$dob = $request->dob;
    		$newDate = Carbon::createFromFormat('d/m/Y', $dob)->format('Y-m-d');
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
        			'added_datetime'=>Carbon::now()

         ];
        $res = User::where('id', $request->id)->update($user_update_data);
        if($res)
        {
            return response()->json(['data'=>'success','msg'=>'User Updated Successfully!']);
        } 
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()->all()]);
        }
    }
    public function userStatus($userid) 
    {
        $userdetails = User::find($userid);
        if ($userdetails->is_active == 1) {
            User::where('id', $userid)->update(['is_active' => 0]);
        } else {
            User::where('id', $userid)->update(['is_active' => 1]);
        }
        return redirect()->back()->with('success', "Status Changed Successfully!");
    }
    public function user_view(Request $request)
    {
    	$id = $request->id;
    	$userdetails = User::find($id);
    	?>
	    	<div class="row">
				<div class="col-lg-4">
					<label class="col-form-label"> Company </label> : <?php echo ($userdetails->getCompany != null)?$userdetails->getCompany['company_name']:"";?>
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">Address 1</label> 
					: <?php echo $userdetails->address_line1 ;?>
					
				</div>
				
				<div class="col-lg-4">
					<label  class="col-form-label">Address 2</label> 
					: <?php echo $userdetails->address_line2 ;?>
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">First Name </label> : <?php echo $userdetails->first_name;?>
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">City</label> 
					: <?php echo $userdetails->city ;?>
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">DOB</label> 
					: <?php echo date('d-m-Y', strtotime($userdetails->dob));?>
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">Middel Name</label> 
					: <?php echo $userdetails->middle_name;?>
		
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">State</label> 
					: <?php echo $userdetails->state ;?>
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">Gender</label> 
					: <?php echo ($userdetails->gender == 1)?"Male":"Female";?>
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">Last Name</label> 
					: <?php echo $userdetails->last_name;?>
					
					
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">Country</label> 
					: <?php echo $userdetails->country ;?>
					
				</div>
				
				<div class="col-lg-4">
					<label  class="col-form-label">Contact No.</label> 
					: <?php echo $userdetails->contact_no ;?>
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">Email</label> 
					: <?php echo $userdetails->email ;?>
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">Zip</label> 
					: <?php echo $userdetails->zip ;?>
					
				</div>
				
				<div class="col-lg-4">
					<label  class="col-form-label">Status</label> 
					: <?php echo ($userdetails->is_active == 1)?"Active":"Inactive"; ;?>
					
				</div>
				<div class="col-lg-4">
					<label  class="col-form-label">User type</label> 
					: <?php echo ($userdetails->getUserTypes != null)?$userdetails->getUserTypes['user_type']:"";?>
					
				</div>
				<?php 
				if($userdetails->user_type_id != 4)
				{
					?>
					<div class="col-lg-4">
						<label  class="col-form-label">Content Writer</label> 
						: <?php echo ($userdetails->is_content_writer ==1)? "Yes":"No";?>
					
					</div>
					<?php
					

				}
				if($userdetails->user_type_id != 3)
				{
					?>
					<div class="col-lg-4">
						<label  class="col-form-label">Qualification</label> 
						: <?php echo $userdetails->qualification ;?>
					
					</div>
					<div class="col-lg-4">
						<label  class="col-form-label">Institution</label> 
						: <?php echo $userdetails->institution ;?>
					
					</div>
					<?php
				}
			?></div>
			 <?php
    }  
}
