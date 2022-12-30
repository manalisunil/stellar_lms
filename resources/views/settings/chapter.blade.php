@extends('layouts.app')
@section('title', 'Chapter')
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
								<th>Sl no</th>
								<th>Subject Name</th>
								<th>Chapter Id</th>
								<th>Name</th>
								<th>Status</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse($chapterList as $k=> $chpDt)
							<tr>
								<td> {{++$k}}</td>
								<td> @if($chpDt->getSubject != null) {{$chpDt->getSubject['subject_name']}} @endif</td>
								<td> {{$chpDt->chapter_id}}</td>
								<td> {{$chpDt->chapter_name}}</td>
								<td>
									<div class="custom-control custom-switch">
										<input type="checkbox"  class="custom-control-input" id="customSwitch{{ $chpDt->id }}"  value="{{ $chpDt->id }}" onclick="chapterstatus(this.value)" @if($chpDt->is_active==1) checked @endif>
										<label class="custom-control-label" for="customSwitch{{ $chpDt->id }}">@if($chpDt->is_active==1) Active @else Inactive @endif</label>
									</div>
								</td>
								<td>
									<span class="btn-primary btn-sm edit_icon"  onClick="view_description({{ $chpDt->id}})">View</span>
								</td>
								<td> 
									<span class="edit_icon edit_chapter ml-2"  data-id="{{ $chpDt->id }}"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</span>
								</td>
							</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</div>
				<div class="p-0" id="chapterdetail">
					<div id="chapter_view_div"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chapteraddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="chptfrm" name="chptfrm"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Chapter</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Subject  <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-3">
							<select required class="form-control" name="subject_id" id="subject_id">
								<option value="">Select Subject</option>
								@forelse($subjectList as $subDt)
								<option value="{{$subDt->id}}"> {{$subDt->subject_name}}</option>
								@empty
								@endforelse
							</select>						
						</div>
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Chapter Id <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-3">
							<input required name="chapter_id" value="" id="chapter_id" type="text" class="form-control" placeholder="Enter Chapter Id" required  />
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-firstname-input" class="col-form-label">Chapter Name <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-3">
							<input required name="chapter_name" value="" id="chapter_name" type="text" class="form-control" placeholder="Enter Chapter Name" required  />
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label">Description <span class="text-danger"> * </span></label><br>
						</div>
						<div class="col-lg-10">
							<textarea class="form-control" name="chapter_description" id="chapter_description" required></textarea>
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
					<button type="submit" class="btn btn-primary" onclick="saveChapter();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="chapterEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
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
					<button type="submit" class="btn btn-primary" onclick="updateChapter();">Submit</button>
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
function backTo_tble()
{
	$("#tbl_list").show();
	$("#chapterdetail").hide();
	$("#chapter_view_div").html("");
}
function view_description(id)
{
	var url = '{{ route("chapter_view_topic") }}';
	$.ajax({
		type: "post",
		url: url,
		data: { id:id , _token: '{{csrf_token()}}'},
		dataType:'html',
		success: function(response)
		{
			$("#chapter_view_div").html(response);
			$("#tbl_list").hide();
			$("#chapterdetail").show();
		}
	});
    
}
function chapterstatus(value)
{
	window.location.href = '/chapterstatus/' + value;
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
$(document).ready(function() {
	$(".odtabs").not("#tab4").addClass('btn-outline-secondary');
	$("#tab4").addClass('btn-secondary');

	$('.modal').on('hidden.bs.modal', function() {
		$(this).find('form')[0].reset();
		
		var frmName = $(this).find('form')[0].name;
		console.log(frmName);
        if(frmName == "chptfrm")
        {

            CKEDITOR.instances['chapter_description'].setData('');
          
        }
  	});

	CKEDITOR.replace('chapter_description');
	var table = $('#datatable').DataTable({
		responsive: true,
		dom: 'l<"toolbar">frtip',
		// buttons: [
		// 	'excel'
		// ],
		initComplete: function(){
		$("div.toolbar").html('<button   type="button" class=" ml-2 btn btn-primary" data-toggle="modal" data-target="#chapteraddModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Chapter</button><br />');
		}
	});
});
	function saveChapter() 
	{
		if ($("#chptfrm").parsley()) {
			if ($("#chptfrm").parsley().validate()) {
				event.preventDefault();
				var formData = new FormData($("#chptfrm")[0]);
				var descValue = CKEDITOR.instances.chapter_description.getData();
				formData.append("descriptionValue", descValue);
				if ($("#chptfrm").parsley().isValid()) {
					$.ajax({
						type: "POST",
						cache:false,
						async: false,
						url: "{{ route('addChapter') }}",
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

	function updateChapter()
	{
		var url = '{{ route("updateChapter") }}';
		if ($("#updatechapterfrm").parsley()) {
			if ($("#updatechapterfrm").parsley().validate()) {
				event.preventDefault();
				var formData = new FormData($("#updatechapterfrm")[0]);
				$descriptionValue = CKEDITOR.instances.chapter_description1.getData();
				formData.append("descriptionValue", $descriptionValue);
				if ($("#updatechapterfrm").parsley().isValid()) {
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