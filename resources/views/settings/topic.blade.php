@extends('layouts.app')
@section('title', 'Topic')
@section('content')
<div class="container-fluid mt-1">
		@include('settings.common_tabs')
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="p-0" id="tbl_list">
						<table id="datatable" class="table table-bordered mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th> Sl no</th>
									<th>Topic Id</th>
									<th>Topic</th>
									<th>Chapter</th>
								    <th width="40%">Introduction</th>
									<th>Description</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($topicList as $k=> $topcDt)
								<tr>
									<td> {{++$k}}</td>
									<td> {{$topcDt->topic_id}}</td>
									<td> {{$topcDt->topic_name}}</td>
									
									<td> @if($topcDt->getChapter != null) {{$topcDt->getChapter['chapter_name']}} @endif</td>
									<td> {{$topcDt->topic_intro}}</td>
									<td>
                                        <span  class="btn-primary btn-sm edit_icon"  onClick="view_description({{ $topcDt->id}})">View</span>
                                    </td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox"  class="custom-control-input" id="customSwitch{{ $topcDt->id }}"  value="{{ $topcDt->id }}" onclick="topicStatus(this.value)" @if($topcDt->is_active==1) checked @endif>
											<label class="custom-control-label" for="customSwitch{{ $topcDt->id }}">@if($topcDt->is_active==1) Active @else Inactive @endif</label>
										</div>
									</td>
									<td> 
										<span class="edit_icon edit_topic ml-2"  data-id="{{ $topcDt->id }}"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</span>
									</td>
								</tr>
								@empty
								@endforelse
							</tbody>
						</table>
					</div>
					<div class="p-0" id="topicdetail">
						<div id="topic_view_div"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="topicaddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<form method="post" id="topicfrm" name="topicfrm"  data-parsley-validate data-parsley-trigger="keyup">
				@csrf
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add Topic</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-1 pr-0">
								<label for="company_select" class="col-form-label"> Chapter  <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
								<select required class="form-control" name="chapter_id" id="chapter_id">
									<option value="">Select Chapter</option>
									@forelse($chapterList as $chpt)
									<option value="{{$chpt->id}}"> {{$chpt->chapter_name}}</option>
									@empty
									@endforelse
								</select>							
							</div>
							<div class="col-lg-1 pr-0">
								<label for="company_select" class="col-form-label"> Topic Id <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
								<input required name="topic_id" value="" id="topic_id" type="text" class="form-control" placeholder="Enter Topic Id" required  />
							</div>
							<div class="col-lg-1 pr-0">
								<label for="example-firstname-input" class="col-form-label">Topic Name <span class="text-danger"> * </span></label>
							</div>
							<div class="col-lg-3">
								<input required name="topic_name" value="" id="topic_name" type="text" class="form-control" placeholder="Enter Topic Name" required  />
							</div>
						</div>
						<div class="row mt-2">
	                        <div class="col-lg-1 pr-0">
	                            <label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Introduction  <span class="text-danger"> * <span></label>
	                        </div>
	                        <div class="col-lg-10">
	                            <textarea  name="topic_intro" id="topic_intro" type="text" class="form-control" placeholder="Enter Introduction" required=""  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-maxlength="300" ></textarea>
	                        </div>
                   		 </div>
						<div class="row mt-2">
							<div class="col-lg-1 pr-0">
								<label for="example-email-input" class="col-form-label">Description <span class="text-danger"> * </span></label><br>
							</div>
							<div class="col-lg-10">
								<textarea class="form-control" name="topic_description" id="topic_description" required></textarea>
							</div>	
						</div>
						<div class="row mt-2">
							<div class="col-lg-1 pr-0">
								<label for="example-email-input" class="col-form-label pr-3">Status </label> 
							</div>
							<div class="col-lg-3 mt-3">
								<input type="checkbox" checked class="" value="1" id="is_active" name="is_active" />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" onclick="saveTopic();">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</div>
<div class="modal fade" id="topicEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="updatetopicfrm" name="updatetopicfrm"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update Topic</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div id="edit_topic_data"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="updateTopic();">Submit</button>
				</div>
			</form>	
		</div>
	</div>
</div>
<div class="modal" id="viewDocModal" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">View Description</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="supportingDoc">
                    <div class="row" id="append_stdoc_view"></div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script type="text/javascript">
function topicStatus(value)
{
	window.location.href = '/topicStatus/' + value;
}
// function view_description(text)
// {
//     $('#viewDocModal').modal('show');
//     $(".modal-body #append_stdoc_view").html(text.topic_description);
    
// }
function backTo_tble()
{
	$("#tbl_list").show();
	$("#topicdetail").hide();
	$("#topic_view_div").html("");
}

function view_description(id)
{
	var url = '{{ route("topic_view_topic") }}';
	$.ajax({
		type: "post",
		url: url,
		data: { id:id , _token: '{{csrf_token()}}'},
		dataType:'html',
		success: function(response)
		{
			$("#topic_view_div").html(response);
			$("#tbl_list").hide();
			$("#topicdetail").show();
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
$(document).ready(function()
{
	$("#topicdetail").hide();
	$(".odtabs").not("#tab5").addClass('btn-outline-secondary');
	$("#tab5").addClass('btn-secondary');
	
	$('.modal').on('hidden.bs.modal', function() {
		$(this).find('form')[0].reset();
		var frmName = $(this).find('form')[0].name;
        if(frmName == "topicaddModal")
        {

            CKEDITOR.instances['topic_description'].setData('');
          
        }
  	});

	CKEDITOR.replace('topic_description');
	var table = $('#datatable').DataTable({
		responsive: true,
		dom: 'l<"toolbar">frtip',
		// buttons: [
		// 	'excel'
		// ],
		initComplete: function(){
		$("div.toolbar").html('<button   type="button" class=" ml-2 btn btn-primary" data-toggle="modal" data-target="#topicaddModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Topic</button><br />');
		}
	});
});

	function saveTopic() 
	{
		if ($("#topicfrm").parsley()) {
        	if ($("#topicfrm").parsley().validate()) {
				event.preventDefault();
				var formData = new FormData($("#topicfrm")[0]);
				var descValue = CKEDITOR.instances.topic_description.getData();
				formData.append("descriptionValue", descValue);
				if($('#topicfrm').parsley().isValid())
				{
					$.ajax({
						type: "POST",
						url: "{{ route('add_topic') }}",
						data: formData,
						processData: false,
						contentType: false,
						success: function(response) {
							new PNotify({
								title: 'Success',
								text:  response.msg,
								type: 'success'
							});
							setTimeout(function(){  location.reload(); }, 800);
						},
						error:function(response) {
							var err = "";
							$.each(response.responseJSON.errors,function(field_name,error){
								err = err +'<br>' + error;
							});
							new PNotify({
								title: 'Error',
								text:err,
								type: 'error',
								delay: 2000
							});
						}
                	});
				}
			}
		}
	}

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

	function updateTopic()
	{
		var url = '{{ route("update_topic") }}';
		if ($("#updatetopicfrm").parsley()) {
			if ($("#updatetopicfrm").parsley().validate()) {
				event.preventDefault();
				var formData = new FormData($("#updatetopicfrm")[0]);
				$descriptionValue = CKEDITOR.instances.topic_description1.getData();
				formData.append("descriptionValue", $descriptionValue);
				if ($("#updatetopicfrm").parsley().isValid()) {
					$.ajax({
						type: "POST",
						cache:false,
						async: false,
						url: url,
						data: formData,
						processData: false,
						contentType: false,
						success: function(response) {
							new PNotify({
								title: 'Success',
								text:  response.msg,
								type: 'success'
							});
							setTimeout(function(){  location.reload(); }, 800);
						},
						error:function(response) {
							var err = "";
							$.each(response.responseJSON.errors,function(field_name,error){
								err = err +'<br>' + error;
							});
							new PNotify({
								title: 'Error',
								text:err,
								type: 'error',
								delay: 2000
							});
						}
					});
				}
			}
		}
	}
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