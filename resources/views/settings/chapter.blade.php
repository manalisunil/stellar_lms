@extends('layouts.app')
@section('title', 'Chapter')
@section('content')
</style>
<div class="container-fluid mt-1">
	@include('settings.common_tabs')
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="p-0">
						<table id="datatable" class="table table-bordered mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th> Sl no</th>
									<th> Company</th>
									<th>Name</th>
									<th> Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($chapterList as $k=> $chpDt)
								<tr>
									<td> {{++$k}}</td>
									<td> @if($chpDt->getSubject != null) {{$chpDt->getSubject['subject_name']}} @endif</td>
									<td> {{$chpDt->chapter_name}}</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox"  class="custom-control-input" id="customSwitch{{ $chpDt->id }}"  value="{{ $chpDt->id }}" onclick="userStatus(this.value)" @if($chpDt->is_active==1) checked @endif>
											<label class="custom-control-label" for="customSwitch{{ $chpDt->id }}">@if($chpDt->is_active==1) Active @else Inactive @endif</label>
										</div>
									</td>
									<td> <span   class="edit_icon edit_chapter ml-2"  data-id="{{ $chpDt->id }}"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</span>
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
	<div class="modal fade" id="chapteraddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Chapter</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" id="chptfrm" name="chptfrm"  data-parsley-validate data-parsley-trigger="keyup">
					@csrf
					<div class="modal-body">
						
						<div class="row">
							<div class="col-lg-4">
								<label for="company_select" class="col-form-label"> Subject  <span class="text-danger"> * </span></label>
								<select required class="form-control" name="subject_id" id="subject_id">
									<option value="">Select Subject</option>
									@forelse($subjectList as $subDt)
									<option value="{{$subDt->id}}"> {{$subDt->subject_name}}</option>
									@empty
									@endforelse
								</select>
								
							</div>
							<div class="col-lg-4">
								<label for="company_select" class="col-form-label"> Chapter Id <span class="text-danger"> * </span></label>
								<input required name="chapter_id" value="" id="chapter_id" type="text" class="form-control" placeholder="Enter Chapter Id" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9][A-Za-z 0-9]*$" />
								
							</div>

							<div class="col-lg-4">
								<label for="example-firstname-input" class="col-form-label">Subject Name <span class="text-danger"> * </span></label>
								<input required name="chapter_name" value="" id="chapter_name" type="text" class="form-control" placeholder="Enter Chapter Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" />
							</div>
							
						</div>
						<div class="row mt-1">
							<div class="col-lg-12">
								<label for="example-email-input" class="col-form-label">Desacription </label><br>
								<textarea class="form-control" name="chapter_description" id="chapter_description" required></textarea>
							</div>	
							
							<div class="col-lg-3">
								<label for="example-email-input" class="col-form-label pr-3">Status </label> 
								<input type="checkbox" checked class="" value="1" id="is_active" name="is_active" />
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
</div>
<div class="modal fade" id="chapterEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update Chapter</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" id="updatechapterfrm" name="updatechapterfrm"  data-parsley-validate data-parsley-trigger="keyup">
					@csrf
				<div id="edit_chapter_data"></div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
				
			</div>
		</div>
	</div>
<script type="text/javascript">
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
$(document).ready(function()
{
	$(".odtabs").not("#tab4").addClass('btn-outline-secondary');
	$("#tab4").addClass('btn-secondary');

	CKEDITOR.replace('chapter_description');
	var table = $('#datatable').DataTable({
		responsive: true,
		dom: 'l<"toolbar">Bfrtip',
		buttons: [
			'excel'
		],
		initComplete: function(){
		$("div.toolbar").html('<button   type="button" class=" ml-2 btn btn-primary" data-toggle="modal" data-target="#chapteraddModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Chapter</button><br />');
		}
	});

	$('#chptfrm').on('submit', function(event)
	{
		event.preventDefault();
		if($('#chptfrm').parsley().isValid())
		{
			var url = '{{ route("addChapter") }}';
			var data = $("#chptfrm").serialize();
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

	$(".edit_chapter").click(function()
	{
		var id = $(this).data('id');
		var url = '{{ route("edit_chapter") }}';
		// alert(id);
		$.ajax({
			type: "post",
			url: url,
			data: { id:id , _token: '{{csrf_token()}}'},
			dataType:'html',
			success: function(response)
			{
				$("#chapterEditModal").modal('show');
				$("#edit_chapter_data").html(response);

				CKEDITOR.replace('chapter_description1');
			
			}
		});
		
	});

	$('#updatechapterfrm').on('submit', function(event)
	{
		event.preventDefault();
		if($('#updatechapterfrm').parsley().isValid())
		{
			var url = '{{ route("updateChapter") }}';
			var data = $("#updatechapterfrm").serialize();
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


});
$(function() {
	$('input[name="dob"]').daterangepicker({
	    singleDatePicker: true,
	    startDate: new Date(),
	    // maxDate: new Date,
	    showDropdowns: true,
	    timePicker: false,
	    timePicker24Hour: false,
	    // timePickerIncrement: 10,
	    autoUpdateInput: true,
	    locale: {
	    format: 'DD/MM/YYYY'
	    },
	});
});
</script>
@endsection