<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use App\Models\User;
use App\Models\UserTypes;

class ProfileController extends Controller
{
	public function index()
    {
        $id = auth()->user()->id;
        $company_id = auth()->user()->company_id;
        $user_type_id = auth()->user()->user_type_id;
        $users = User::where('id','=',$id)->first();
        $company = Company::select('company_name')->where('id','=',$company_id)->first();
        $user_types = UserTypes::find($user_type_id);
        $userTypes = UserTypes::where('id','!=',1)->get();
      
        $companies = Company::where('is_active',1)->get();

        return view('includes/profile',compact('users','company','user_type_id','user_types','userTypes','companies'));
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            // 'company_id'=>'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:mdblms_users,email,'.$request->id,
            'user_type_id' => 'required',
            // 'gender'=>'required',
			// 'dob' => 'nullable|before:' .$before
        ]);
    	if(isset($request->dob))
    	{
    		$dob = $request->dob;
    		$newDate = Carbon::createFromFormat('Y-m-d', $dob)->format('Y-m-d');
    	}
    	else
    	{
    		$newDate = NULL;
    	}
        
       
       
        $user_dt =  User::find($request->id);
        $user_dt->first_name  = $request->first_name;
        $user_dt->middle_name  = $request->middle_name;
        $user_dt->last_name  = $request->last_name;
        $user_dt->email  = $request->email;
        if($request->password != null || $request->password !="")
        {
            $user_dt->password  =Hash::make($request->password);
        }
        $user_dt->gender= (isset($request->gender) && $request->gender ==1) ? 1 : 2 ;
		$user_dt->dob= $newDate;
		$user_dt->contact_no= $request->contact_no;
		$user_dt->email= $request->email;
		$user_dt->address_line1= $request->address_line1;
		$user_dt->address_line2= $request->address_line2;
		$user_dt->city= $request->city;
		$user_dt->state= $request->state;
		$user_dt->country= $request->country;
		$user_dt->zip= $request->zip;
	
		$user_dt->is_content_writer= isset($request->is_content_writer)? 1 : 0;
		$user_dt->is_active= isset($request->is_active) ? 1 : 0;
        $res = $user_dt->save();
           
        if($res)
        {
            return response()->json(['data'=>'success','msg'=>'Profile Updated Successfully!']);
        } 
        else 
        {
            return response()->json(['data'=>'error','msg'=>$validator->errors()]);
        }
    }
}
