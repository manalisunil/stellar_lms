@extends('layouts.app')
@section('title', 'Topic')
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
									<th>Chapter</th>
									<th>Topic</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($topicList as $k=> $topcDt)
								<tr>
									<td> {{++$k}}</td>
									<td> @if($topcDt->getChapter != null) {{$topcDt->getChapter['chapter_name']}} @endif</td>
									<td> {{$topcDt->topic_name}}</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox"  class="custom-control-input" id="customSwitch{{ $topcDt->id }}"  value="{{ $topcDt->id }}" onclick="userStatus(this.value)" @if($topcDt->is_active==1) checked @endif>
											<label class="custom-control-label" for="customSwitch{{ $topcDt->id }}">@if($topcDt->is_active==1) Active @else Inactive @endif</label>
										</div>
									</td>
									<td> <span   class="edit_icon edit_topic ml-2"  data-id="{{ $topcDt->id }}"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</span>
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
	<div class="modal fade" id="topicaddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Topic</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" id="topicfrm" name="topicfrm"  data-parsley-validate data-parsley-trigger="keyup">
					@csrf
					<div class="modal-body">
						
						<div class="row">
							<div class="col-lg-4">
								<label for="company_select" class="col-form-label"> Chapter  <span class="text-danger"> * </span></label>
								<select required class="form-control" name="chapter_id" id="chapter_id">
									<option value="">Select Chapter</option>
									@forelse($chapterList as $chpt)
									<option value="{{$chpt->id}}"> {{$chpt->chapter_name}}</option>
									@empty
									@endforelse
								</select>
								
							</div>
							<div class="col-lg-4">
								<label for="company_select" class="col-form-label"> Topic Id <span class="text-danger"> * </span></label>
								<input required name="topic_id" value="" id="topic_id" type="text" class="form-control" placeholder="Enter Topic Id" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9][A-Za-z 0-9]*$" />
								
							</div>

							<div class="col-lg-4">
								<label for="example-firstname-input" class="col-form-label">Topic Name <span class="text-danger"> * </span></label>
								<input required name="topic_name" value="" id="topic_name" type="text" class="form-control" placeholder="Enter Topic Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$" />
							</div>
							
						</div>
						<div class="row mt-1">
							<div class="col-lg-12">
								<label for="example-email-input" class="col-form-label">Desacription </label><br>
								<textarea class="form-control" name="topic_description" id="topic_description" required></textarea>
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
<div class="modal fade" id="topicEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update Topic</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" id="updatetopicfrm" name="updatetopicfrm"  data-parsley-validate data-parsley-trigger="keyup">
					@csrf
				<div id="edit_topic_data"></div>
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
	$(".odtabs").not("#tab5").addClass('btn-outline-secondary');
	$("#tab5").addClass('btn-secondary');
	
	CKEDITOR.replace('topic_description');
	var table = $('#datatable').DataTable({
		responsive: true,
		dom: 'l<"toolbar">Bfrtip',
		buttons: [
			'excel'
		],
		initComplete: function(){
		$("div.toolbar").html('<button   type="button" class=" ml-2 btn btn-primary" data-toggle="modal" data-target="#topicaddModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Topic</button><br />');
		}
	});

	$('#topicfrm').on('submit', function(event)
	{
		event.preventDefault();
		if($('#topicfrm').parsley().isValid())
		{
			var url = '{{ route("add_topic") }}';
			var data = $("#topicfrm").serialize();
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

	$(".edit_topic").click(function()
	{
		var id = $(this).data('id');
		var url = '{{ route("edit_topic") }}';
		// alert(id);
		$.ajax({
			type: "post",
			url: url,
			data: { id:id , _token: '{{csrf_token()}}'},
			dataType:'html',
			success: function(response)
			{
				$("#topicEditModal").modal('show');
				$("#edit_topic_data").html(response);

				CKEDITOR.replace('topic_description1');
			
			}
		});
		
	});

	$('#updatetopicfrm').on('submit', function(event)
	{
		event.preventDefault();
		if($('#updatetopicfrm').parsley().isValid())
		{
			var url = '{{ route("update_topic") }}';
			var data = $("#updatetopicfrm").serialize();
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