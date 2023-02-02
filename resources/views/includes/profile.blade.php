@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<style type="text/css">
	p{
		font-weight: 600;
	}
</style>
<div class="container-fluid mt-4">
	<div class="card shadow-lg">
		<div class="card-header card_header" >
			<h4 class="mt-3 text-left"><a href="{{ route('home') }}"><i class="fa-solid fa-circle-arrow-left"></i></a> Profile </h4>
		</div></br>
		<div class="card-body p-0 ">
			<div class="d-flex flex-row-reverse bd-highlight ml-2" >
				<div class="text-right mx-4">
					<span class="edit_profile" style="cursor:pointer;"><i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit</span>
                    <span class="back_profile d-none" >
						<a href="{{ route('profile') }}" style="text-decoration: none;color: #212529!important;">
							<i class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back
						</a>
					</span>
                </div>
			</div>
			<div class="row mt-3 display_div mx-3">
				<div class="col-lg-12">
					<div class="card mb-4">
						<div class="card-body">
							<div class="row mt-3">
								<div class="col-sm-2">
									<p class="mb-0">First Name</p>
								</div>
								<div class="col-sm-4">
									<p class="text-muted mb-0">{{$users->first_name    }}</p>
								</div>
								<div class="col-sm-2">
									<p class="mb-0">Middle Name</p>
								</div>
								<div class="col-sm-4">
									<p class="text-muted mb-0">  {{$users->middle_name}}</p>
								</div>
							</div>
							<hr>
                            <div class="row">
                                
                                <div class="col-sm-2">
                                    <p class="mb-0">Last Name</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">  {{$users->last_name}}</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="mb-0">Gender</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{(($users->gender ==1)?'Male':'Female') }}</p>
                                </div>
                            </div>
                            <hr>
							<div class="row">
								<div class="col-sm-2">
									<p class="mb-0">Email</p>
								</div>
								<div class="col-sm-4">
									<p class="text-muted mb-0">{{$users->email}}</p>
								</div>
                                <div class="col-sm-2">
									<p class="mb-0">Company</p>
								</div>
								<div class="col-sm-4">
									<p class="text-muted mb-0">{{$company->company_name}}</p>
								</div>
							</div>
							<hr>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p class="mb-0">Contact Number</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{$users->contact_no}}</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="mb-0">Date of Birth</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{ date('d-m-Y', strtotime($users->dob)) }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p class="mb-0">Address 1</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{$users->address_line1}}</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="mb-0">Address 2</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{$users->address_line2}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p class="mb-0">City</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{$users->city}}</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="mb-0">State</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{$users->state}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p class="mb-0">Country</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{$users->country}}</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="mb-0">Zip</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">{{$users->zip}}</p>
                                </div>
                            </div>
                            <hr>

							<div class="row">
                                <div class="col-sm-2">
									<p class="mb-0">User Type</p>
								</div>
								<div class="col-sm-4">
									<p class="text-muted mb-0">{{$user_types->user_type}}</p>
								</div>
                               
						<!-- 	</div>
							<hr>
							<div class="row"> -->
								<div class="col-sm-2">
									<p class="mb-0">Status</p>
								</div>
								<div class="col-sm-4">
									<p class="text-muted mb-0">@if($users->is_active == 1) Active @else Inactive @endif</p>
								</div>
							</div>
                            @if($users->user_type_id == 3)
                            <hr>

                            <div class="row">
                                <div class="col-sm-2">
                                    <p class="mb-0">Is Content Writer</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted mb-0">@if($users->is_content_writer == 1) Yes @else No @endif</p>
                                </div>
                               
                        
                            </div>
                            @endif
                           
                           
						</div>
					</div>
				</div>
			</div>
            <div class="mt-3 edit_div d-none mx-3" >
                <form id="update_profile" method="POST" action="{{route('update_profile')}}" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <input type="hidden" name="id" value="{{$users->id}}">
                    <div class="row">
                        <div class="col-lg-12">	
                            <div class="card mb-4">	
                                <d iv class="card-body">
                                    <div class="row">
                            <div class="col-lg-1 pr-0">
                                <label for="company_select" class="col-form-label"> Company <span class="text-danger"> * </span></label>
                            </div>
                            <div class="col-lg-3">
                                <select required class="form-control" name="company_id" id="company_id" readonly disabled="">
                                    <option value="">Select Company</option>';
                                    @foreach($companies as $compDt) 
                                    {
                                        <option value="{{$compDt->id}}" @if($compDt->id == $users->company_id) {
                                       selected="selected";
                                        } @endif
                                        >{{$compDt->company_name}}</option>
                                    }
                                    @endforeach

                            </select>
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="example-firstname-input" class="col-form-label">First Name <span class="text-danger"> * </span></label>
                            </div>
                            <div class="col-lg-3">
                                <input required name="first_name" value="{{$users->first_name}}" id="first_name" type="text" class="form-control" placeholder="Enter First Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" />
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="example-mname-input" class="col-form-label">Middle Name</label>
                            </div>
                            <div class="col-lg-3">
                                <input autocomplete="off"  value="{{$users->middle_name}}" name="middle_name" id="middle_name" type="text" class="form-control" placeholder="Enter Middle Name" data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-lg-1 pr-0">
                                <label for="example-firstname-input" class="col-form-label">Last Name</label>
                            </div>
                            <div class="col-lg-3">
                                <input autocomplete="off"  value="{{$users->last_name}}" name="last_name" id="last_name" type="text" class="form-control" placeholder="Enter Last Name" data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>
                            </div>
                          
                            <div class="col-lg-1 pr-0">
                                <label for="active-input" class="col-form-label">Gender </label>
                            </div>
                            <div class="col-lg-3">
                                <div class="mt-2">
                                    <input type="radio" id="gender" name="gender" value="1" 
                                     @if ($users->gender == 1)
                                       checked
                                    @endif
                                   >Male 
                                   <input type="radio" id="gender" name="gender" value="0"
                                        @if ($users->gender == 2)
                                            checked
       
                                        @endif
                                    >Female
                                </div>
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="company_select" class="col-form-label"> User Type <span class="text-danger"> * </span></label>
                            </div>
                            <div class="col-lg-3">
                                <select required class="form-control user_type_change" name="user_type_id" id="ed_user_type_id" >
                                    <option value="">Select User Type</option>';
                                
                                    @foreach($userTypes as $userTy) 
                                    
                                        $output.='<option value="{{$userTy->id}}"
                                        @if($userTy->id == $users->user_type_id)
                                        selected="selected"
                                        @endif
                                      >{{$userTy->user_type}}</option>';
                                    @endforeach
                            $output.='</select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-lg-1 pr-0">
                                <label for="name-input" class="col-form-label">Contact Number<span class="text-danger">  <span></label>
                            </div>
                            <div class="col-lg-3">
                                <input data-parsley-type="number" data-parsley-trigger="change" data-parsley-minlength="10" 
                                data-parsley-maxlength="15" id="contact_no" name="contact_no" type="text" class="form-control" autocomplete="off" placeholder="Enter Contact Number" value="{{$users->contact_no}}" data-parsley-minlength-message="Number should be Minimum 10 digits"  data-parsley-maxlength-message="Number should be max 15 digits" data-parsley-trigger="keyup" data-parsley-trigger="focusout">
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="active-input" class="col-form-label">Date of Birth </label>
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control " name="dob" id="eddob" type="date" value="{{$users->dob}}" class="js-validate-dob" data-parsley-minimumage="15" 
                            data-parsley-minimumage-message="Applicant must be at least 15 years of age to apply" data-parsley-validdate="" data-parsley-validdate-message="Please enter a valid date" data-parsley-pattern="/[0-9]\d*/"  data-parsley-trigger="keyup" data-parsley-trigger="focusout"
                            data-parsley-pattern-message="Only numbers allowed"    ata-parsley-validation-threshold="0" />
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="name-input" class="col-form-label">Address 1<span class="text-danger">  <span></label>
                            </div>
                            <div class="col-lg-3">
                                <input id="address_line1" name="address_line1" type="text" class="form-control" autocomplete="off" placeholder="Enter Address" value="{{$users->address_line1}}" >
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-lg-1 pr-0">
                                <label for="name-input" class="col-form-label">Address 2<span class="text-danger">  <span></label>
                            </div>
                             <div class="col-lg-3">
                                <input id="address_line2" name="address_line2" type="text" class="form-control" autocomplete="off" placeholder="Enter Address" value="{{$users->address_line2}}" >
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="example-email-input" class="col-form-label">Email <span class="text-danger"> * </span></label>
                            </div>
                            <div class="col-lg-3">
                                <input autocomplete="off" required value="{{$users->email}}" name="email" id="email" type="email" class="form-control" placeholder="Enter Email" data-parsley-type="email" data-parsley-trigger="keyup" data-parsley-trigger="focusout"/>
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="example-email-input" class="col-form-label"> New Password<span class="text-danger"> * </span> </label>
                            </div>
                            <div class="col-lg-3">
                                <input id="password" name="password" type="text" class="form-control" autocomplete="off"    placeholder="Enter Password"   data-parsley-minlength="8"
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
                                <input id="city" name="city" type="text" class="form-control" autocomplete="off" placeholder="Enter City"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="{{$users->city}}">
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="name-input" class="col-form-label">State<span class="text-danger"><span></label>
                            </div>
                            <div class="col-lg-3">
                                <input id="state" name="state" type="text" class="form-control" autocomplete="off" placeholder="Enter State"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="{{$users->state}}">
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="name-input" class="col-form-label">Country<span class="text-danger"><span></label>
                            </div>
                            <div class="col-lg-3">
                                <input id="country" name="country" type="text" class="form-control" autocomplete="off" placeholder="Enter Country"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" value="{{$users->country}}">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-lg-1 pr-0">
                                <label for="name-input" class="col-form-label">Zip<span class="text-danger"><span></label>
                            </div>
                            <div class="col-lg-3">
                                <input data-parsley-type="integer" data-parsley-trigger="keyup" id="zip" name="zip" type="text" class="form-control" autocomplete="off" placeholder="Enter Zipcode" data-parsley-type-message ="This value should be a valid number" value="{{$users->zip}}">
                            </div>
                            
                       <!--  </div>
                        <div class="row mt-1"> -->

                            <div class="col-lg-1 pr-0 tutor_div">
                                <label for="example-email-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Is Content Writer </label><br>
                            </div>
                            <div class="col-lg-3 mt-3 tutor_div">
                                <input type="checkbox"  value="1" id="is_content_writer" name="is_content_writer" 
                                @if ($users->is_content_writer == 1)
                                    'checked'
                                @else 
                                    ''
                                @endif
                                >
                            </div>
                            <div class="col-lg-1 pr-0">
                                <label for="example-email-input" class="col-form-label">Status </label><br>
                            </div>  
                            <div class="col-lg-3 mt-3">
                                <input type="checkbox" value="1" id="is_active" name="is_active" 
                                @if ($users->is_active == 1)
                                checked
                             
                                @endif
                               >
                            </div>
                        </div>	
                        </div>
                            <div class=" text-center mb-4">
                                <a href="{{ route('profile') }}"><button type="button" class="btn btn-danger btn-sm cancel_btn">CANCEL</button></a>
                                <button type="submit" class="btn btn-success btn-sm submit_btn" >SUBMIT</button>
                            </div>	
				        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function () {
    @if(Session::has('success'))
    new PNotify({
    title: 'Success',
    text:  "{{Session::get('success')}}",
    type: 'success'
    });
            
    @endif
    @if ($errors->any())
        
        @foreach ($errors->all() as $error)
        
        new PNotify({
        title: 'Error',
        text:  "{{ $error }}",
        type: 'error'
        });
        @endforeach
        
    @endif
});
$(document).ready(function(){
    $(".edit_profile").click(function()
    {
        $(".display_div").addClass('d-none');
        $(".edit_div").removeClass('d-none');
        $(".edit_profile").addClass('d-none');
        $(".back_profile").removeClass('d-none');
    });

    window.Parsley.addValidator('uppercase', {
        requirementType: 'number',
        validateString: function(value, requirement) {
            var uppercases = value.match(/[A-Z]/g) || [];
            return uppercases.length >= requirement;
        },
        messages: {
            en: 'Your password must contain at least (%s) uppercase letter.'
        }
    });

    //has lowercase
    window.Parsley.addValidator('lowercase', {
        requirementType: 'number',
        validateString: function(value, requirement) {
            var lowecases = value.match(/[a-z]/g) || [];
            return lowecases.length >= requirement;
        },
        messages: {
            en: 'Your password must contain at least (%s) lowercase letter.'
        }
    });

    //has number
    window.Parsley.addValidator('number', {
        requirementType: 'number',
        validateString: function(value, requirement) {
            var numbers = value.match(/[0-9]/g) || [];
            return numbers.length >= requirement;
        },
        messages: {
            en: 'Your password must contain at least (%s) number.'
        }
    });

    //has special char
    window.Parsley.addValidator('special', {
        requirementType: 'number',
        validateString: function(value, requirement) {
            var specials = value.match(/[^a-zA-Z0-9]/g) || [];
            return specials.length >= requirement;
        },
        messages: {
            en: 'Your password must contain at least (%s) special characters.'
        }
    });
    window.Parsley.addValidator("minimumage", {
        validateString: function(value, requirements) {
            // get validation requirments
            var reqs = value.split("/"),
                day = reqs[0],
                month = reqs[1],
                year = reqs[2];

                // console.log(value);
                // console.log(year);
                // console.log(month);
                // console.log(day);
            // check if date is a valid
            var birthday = new Date(year + "-" + month + "-" + day);
            // Calculate birtday and check if age is greater than 18
            var today = new Date();

            var age = today.getFullYear() - birthday.getFullYear();
            var m = today.getMonth() - birthday.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) {
                age--;
            }
            // console.log(age);
            return age >= requirements;
        }
    });


    $('#update_profile').parsley();
    $('#update_profile').on('submit', function(event){
        event.preventDefault();
        if($('#update_profile').parsley().isValid())
        {
            var url = '{{ route("update_profile") }}';
            $.ajax({
                type: "post",
                url: url,
                data: new FormData($("#update_profile")[0]),
                processData: false,
                contentType: false,
                success: function(response) 
                {
                    if(response.data =='success')
                    {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success'
                            });
                            setTimeout(function(){  location.reload(); }, 1000);                    }
                    else
                    {
                        new PNotify({
                        title: 'Error',
                        text:  response.msg,
                        type: 'error',
                        delay: 1000
                        });
                    }
                    
                    
                },
                error: function(response) 
                {
                    var err = "";
                        $.each(response.responseJSON.errors,function(field_name,error){
                    
                    err = err +'<br>' + error;
                    });
                        new PNotify({
                        title: 'Error',
                        text:  err,
                        type: 'error',
                        delay: 1000
                    });
                },	
            });
        }
    });
});

</script>

@endsection