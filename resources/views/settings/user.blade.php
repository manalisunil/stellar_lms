@extends('layouts.app')
@section('title', 'User')
@section('content')
<div class="container-fluid mt-1">
	@include('settings.common_tabs')
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="p-0">
					<table id="datatable" class="table table-bordered mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Sl no</th>
								<th>Company</th>
								<th>Name</th>
								<th>Email</th>
								<th>User Role</th>
								<th>Status</th>
								<th>Details</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse($userList as $k=> $userDt)
							<tr>
								<td> {{++$k}}</td>
								<td> @if($userDt->getCompany != null) {{$userDt->getCompany['company_name']}} @endif</td>
								<td> {{$userDt->first_name}} {{$userDt->middle_name}} {{$userDt->last_name}}</td>
								<td> {{$userDt->email}}</td>
								<td> {{$userDt->getUserTypes['user_type']}}</td>
								<td>
									<div class="custom-control custom-switch">
										<input type="checkbox"  class="custom-control-input" id="customSwitch{{ $userDt->id }}"  value="{{ $userDt->id }}" onclick="userStatus(this.value)" @if($userDt->is_active==1) checked @endif>
										<label class="custom-control-label" for="customSwitch{{ $userDt->id }}">@if($userDt->is_active==1) Active @else Inactive @endif</label>
									</div>
								</td>
								<td>
									<span class="btn-primary btn-sm edit_icon"  onClick="view_detail({{ $userDt->id}})">View</span>
								</td>
								<td> 
									<span class="edit_icon edit_user ml-2"  data-id="{{ $userDt->id }}"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</span>
								</td>
							</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="useraddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add user</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="userfrm" name="userfrm"  autocomplete="off" data-parsley-validate data-parsley-trigger="keyup" >
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Company <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-3">
							<select required class="form-control" name="company_id" id="company_id">
								<option value="">Select Company</option>
								@forelse($companyList as $compDt)
								<option value="{{$compDt->id}}"> {{$compDt->company_name}}</option>
								@empty
								@endforelse
							</select>							
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-firstname-input" class="col-form-label">First Name <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-3">
							<input required name="first_name" value="" id="first_name" type="text" class="form-control" placeholder="Enter First Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" />
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-mname-input" class="col-form-label">Middle Name</label>
						</div>
						<div class="col-lg-3">
							<input autocomplete="off"  value="" name="middle_name" id="middle_name" type="text" class="form-control" placeholder="Enter Middle Name" data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-lg-1 pr-0">
							<label for="example-firstname-input" class="col-form-label">Last Name</label>
						</div>
						<div class="col-lg-3">
							<input autocomplete="off"  value="" name="last_name" id="last_name" type="text" class="form-control" placeholder="Enter Last Name" data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>			
						</div>
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> User Type <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-3">
							<select required class="form-control user_type_change" name="user_type_id" id="user_type_id" >
								<option value="">Select User Type</option>
								@forelse($usertypesList as $userTy)
								<option value="{{$userTy->id}}"> {{$userTy->user_type}}</option>
								@empty
								@endforelse
							</select>							
						</div>
						<div class="col-lg-1 pr-0">
							<label for="active-input" class="col-form-label">Gender </label>
						</div>
						<div class="col-lg-3 mt-2">
							<input type="radio" id="gender" name="gender" value="1" checked>Male 
							<input type="radio" id="gender" name="gender" value="0" >Female							
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-lg-1 pr-0">
							<label for="name-input" class="col-form-label">Contact Number<span class="text-danger">  <span></label>
						</div>
						<div class="col-lg-3">
							<input data-parsley-type="number" data-parsley-trigger="change" data-parsley-minlength="10"   data-parsley-maxlength="15" id="contact_no" name="contact_no" type="text" class="form-control" autocomplete="off" placeholder="Enter Contact Number" data-parsley-minlength-message="Number should be Minimum 10 digits"  data-parsley-maxlength-message="Number should be max 15 digits" data-parsley-trigger="keyup" data-parsley-trigger="focusout" >							
						</div>
						<div class="col-lg-1 pr-0">
							<label for="active-input" class="col-form-label">Date of Birth </label>
						</div>
						<div class="col-lg-3">
							<input class="form-control" name="dob" id="dob" type="date" class="js-validate-dob" value="" data-parsley-minimumage="15" 
							data-parsley-minimumage-message="Applicant must be at least 15 years of age to apply" data-parsley-validdate="" data-parsley-validdate-message="Please enter a valid date" data-parsley-pattern="/[0-9]\d*/"
	 						data-parsley-pattern-message="Only numbers allowed" data-parsley-trigger="keyup" data-parsley-trigger="focusout"  data-parsley-validation-threshold="0" />							
						</div>
						<div class="col-lg-1 pr-0">
							<label for="name-input" class="col-form-label">Address 1<span class="text-danger">  <span></label>
						</div>
						<div class="col-lg-3">
							<input id="address_line1" name="address_line1" type="text" class="form-control" autocomplete="off" placeholder="Enter Address" >
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-lg-1 pr-0">
							<label for="name-input" class="col-form-label">Address 2<span class="text-danger">  <span></label>
						</div>
						<div class="col-lg-3">
							<input id="address_line2" name="address_line2" type="text" class="form-control" autocomplete="off" placeholder="Enter Address" >
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label">Email <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-3">
							<input autocomplete="off" required value="" name="email" id="email" type="email" class="form-control" placeholder="Enter Email" data-parsley-type="email" data-parsley-trigger="keyup" data-parsley-trigger="focusout"/>
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label"> Password<span class="text-danger"> * </span> </label>
						</div>
						<div class="col-lg-3">
							<input id="password" name="password" type="text" class="form-control" autocomplete="off" 	placeholder="Enter Password"  required data-parsley-minlength="8"
							data-parsley-errors-container=".errorspannewpassinput"
							data-parsley-required-message="Please enter your new password."
							data-parsley-uppercase="1"
							data-parsley-lowercase="1"
							data-parsley-number="1"
							data-parsley-special="1"
							data-parsley-required>
							<span class="errorspannewpassinput" style="font-weight: 400;"></span>							
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-lg-1 pr-0">
							<label for="name-input" class="col-form-label">City<span class="text-danger"><span></label>
						</div>
						<div class="col-lg-3">
							<input id="city" name="city" type="text" class="form-control" autocomplete="off" placeholder="Enter City"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$">
						</div>
						<div class="col-lg-1 pr-0">
							<label for="name-input" class="col-form-label">State<span class="text-danger"><span></label>
						</div>
						<div class="col-lg-3">
							<input id="state" name="state" type="text" class="form-control" autocomplete="off" placeholder="Enter State"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$">
						</div>
						<div class="col-lg-1 pr-0">
							<label for="name-input" class="col-form-label">Country<span class="text-danger"><span></label>
						</div>
						<div class="col-lg-3">
							<input id="country" name="country" type="text" class="form-control" autocomplete="off" placeholder="Enter Country"  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$">
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-lg-1 pr-0">
							<label for="name-input" class="col-form-label">Zip<span class="text-danger"> <span></label>
						</div>
						<div class="col-lg-3">
							<input data-parsley-type="integer" data-parsley-trigger="keyup" id="zip" name="zip" type="text" class="form-control" autocomplete="off" placeholder="Enter Zipcode" data-parsley-type-message ="This value should be a valid number">
						</div>
						<div class="col-lg-1 pr-0 user_type_div">
							<label for="name-input" class="col-form-label">Qualification<span class="text-danger"> <span></label>
						</div>
						<div class="col-lg-3 user_type_div">
							<input id="qualification" name="qualification" type="text" class="form-control" autocomplete="off" placeholder="Enter qualification"   >
						</div>
						<div class="col-lg-1 pr-0 user_type_div">
							<label for="name-input" class="col-form-label">Institution<span class="text-danger"> <span></label>
						</div>
						<div class="col-lg-3 user_type_div">
							<input id="institution" name="institution" type="text" class="form-control" autocomplete="off" placeholder="Enter institution"  >
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-lg-1 pr-0 tutor_div">
							<label for="example-email-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Is Content Writer </label><br>
						</div>
						<div class="col-lg-3 mt-3 tutor_div">
							<input type="checkbox"  value="1" id="is_content_writer" name="is_content_writer" />
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label">Status </label><br>
						</div>
						<div class="col-lg-3 mt-3">
							<input type="checkbox" checked value="1" id="is_active" name="is_active" />
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Update user</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="updateuserfrm" name="updateuserfrm"  data-parsley-validate data-parsley-trigger="keyup" >
				@csrf
			<div id="edituserdata"></div>
			<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
			
		</div>
	</div>
</div>
<div class="modal fade" id="userviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">User Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewuserdata"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function userStatus(value)
{
	window.location.href = '/userStatus/' + value;
}
function view_detail(id)
{
	var url = '{{ route("user_view_topic") }}';
	$.ajax({
		type: "post",
		url: url,
		data: { id:id , _token: '{{csrf_token()}}'},
		dataType:'html',
		success: function(response)
		{
			$('#userviewModal').modal('show');
			$("#viewuserdata").html(response);
		}
	});

}
$(function () 
{
	@if(Session::has('success'))
		new PNotify({
		title: 'Success',
		delay: 500,
		text:  "{{Session::get('success')}}",
		type: 'success'
	});
			
	@endif
	@if ($errors->any())
		var err = "";
		@foreach ($errors->all() as $error)
			new PNotify({
				title: 'Error',
				text: "{{$error}}",
				delay: 800,
				type: 'error'
			});
		@endforeach
	@endif
});

$(document).on('change', '.user_type_change', function() 
{
  	var id = $(this).val();
  	if(id == 3)
  	{
  		$(".user_type_div").hide();
  		$(".tutor_div").show();
  	}
  	else if(id == 4)
  	{
  		$(".user_type_div").show();
  		$(".tutor_div").hide();
  	}
  	else
  	{
  		$(".user_type_div").show();
  		$(".tutor_div").show();
  	}
});
$(document).ready(function()
{
	$(".odtabs").not("#tab2").addClass('btn-outline-secondary');
	$("#tab2").addClass('btn-secondary');

	$('.modal').on('hidden.bs.modal', function() {
		$(this).find('form')[0].reset();
  	});

	var table = $('#datatable').DataTable({
		responsive: true,
		dom: 'l<"toolbar">frtip',
		// buttons: [
		// 	'excel'
		// ],
		initComplete: function(){
			$("div.toolbar").html('<button   type="button" class=" ml-2 btn btn-primary" data-toggle="modal" data-target="#useraddModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add User</button><br />');
		}
	});

	$('#userfrm').on('submit', function(event)
	{
		event.preventDefault();
		if($('#userfrm').parsley().isValid())
		{
			var url = '{{ route("addUser") }}';
			var data = $("#userfrm").serialize();
			$.ajax({
				type: "post",
				url: url,
				data: data,
				success: function(response) {
					if(response.data =='success')
					{
						new PNotify({
							title: 'Success',
							text:  response.msg,
							type: 'success'
							});
						setTimeout(function(){  location.reload(); }, 800);
					}
					else
					{
						new PNotify({
						title: 'Error',
						text:  response.msg,
						type: 'error'
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
							type: 'error'
					});
					
				},
			});
		}
	});

	$(".edit_user").click(function()
	{
		var id = $(this).data('id');
		var url = '{{ route("edit_user") }}';
		// alert(id);
		$.ajax({
			type: "post",
			url: url,
			data: { id:id , _token: '{{csrf_token()}}'},
			dataType:'html',
			success: function(response)
			{

				$("#userEditModal").modal('show');
				$("#edituserdata").html(response);
				
				var id = $("#ed_user_type_id").val();
				if(id == 3)
			  	{
			  		$(".user_type_div").hide();
			  		$(".tutor_div").show();
			  	}
			  	else if(id == 4)
			  	{
			  		$(".user_type_div").show();
			  		$(".tutor_div").hide();
			  	}
			  	else
			  	{
			  		$(".user_type_div").show();
			  		$(".tutor_div").show();
			  	}
			 //     var eddob = $("#eddob").val();
			 //  	$('input[name="dob"]').daterangepicker({
				//     singleDatePicker: true,
				//     // startDate: new Date(),
				// 	// startDate: new Date(val(response.dob)),
				//     // maxDate: new Date,
				//     showDropdowns: true,
				//     timePicker: false,
				//     timePicker24Hour: false,
				//     // timePickerIncrement: 10,
				//     autoUpdateInput: true,
				//     locale: {
				//     format: 'DD/MM/YYYY'
				//     },
				// });
			 //  	if(eddob == "")
			 //  	{
				// 	$('input[name="dob"]').val("");

			 //  	}
			}
		});
		
	});

	$('#updateuserfrm').on('submit', function(event)
	{
		event.preventDefault();
		if($('#updateuserfrm').parsley().isValid())
		{
			var url = '{{ route("updateUser") }}';
			var data = $("#updateuserfrm").serialize();
			$.ajax({
				type: "post",
				url: url,
				data: data,
				success: function(response) 
				{
					if(response.data =='success')
					{
						new PNotify({
							title: 'Success',
							text:  response.msg,
							type: 'success'
							});
						setTimeout(function(){  location.reload(); }, 800);
					}
					else
					{
						new PNotify({
						title: 'Error',
						text:  response.msg,
						type: 'error'
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
							type: 'error'
							});
					
				},
			});
		}
	});
});
$(document).ready(function()
{
	
	//has uppercase
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

	/* add validation for minimum age */
	// window.Parsley.addValidator("validdate", {
	// 	validateString: function(value) {
	// 		// get validation requirments
	// 		var reqs = value.split("/"),
	// 			day = reqs[0],
	// 			month = reqs[1],
	// 			year = reqs[2];

	// 		// check if date is a valid
	// 		var birthday = new Date(year + "-" + month + "-" + day);
	// 		var isValidDate =
	// 			Boolean(+birthday) && birthday.getDate().toString() === day;

	// 		return isValidDate;
	// 	},
	// 	messages: {
	// 		en: ""
	// 	}
	// });
});


$(function() {
	// $('input[name="dob"]').daterangepicker({
	//     singleDatePicker: true,
	// 	// minDate: new Date(1900,1-1,1), 
	// 	// maxDate: '-18Y',
	// 	// yearRange: '-110:-18',
	//     // startDate: new Date(),
	//     maxDate: new Date,
	//     showDropdowns: true,
	//     timePicker: false,
	//     timePicker24Hour: false,
	//     // timePickerIncrement: 10,
	//     autoUpdateInput: true,
	//     locale: {
	//     format: 'DD/MM/YYYY'
	//     },
	// });
	//  $('input[name="dob"]').val("");
});
</script>
@endsection