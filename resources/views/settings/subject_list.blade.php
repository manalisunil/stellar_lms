@extends('layouts.app')
@section('title', 'Subject')
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
                                <th>Sl No</th>
                                <th>Subject Id</th>
                                <th>Subject Name</th>
                                <th width="50%">Introduction</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjects as $k=>$subject)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{{$subject->subject_id}}</td>
                                <td>{{$subject->subject_name}}</td>
                                <td>{{$subject->subject_intro}}</td>
                                <td>
                                    @if(!empty($subject->subject_description))
                                        <span class="btn-primary btn-sm edit_icon"  onClick="view_description({{ $subject->id}})">View</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"  class="custom-control-input" id="customSwitch{{ $subject->id }}"  value="{{ $subject->id }}" onclick="subjectStatus(this.value)" @if($subject->is_active==1) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{ $subject->id }}">@if($subject->is_active==1) Active @else Inactive @endif</label>
                                    </div>
                                </td>
                                <td> 
                                    <span class="edit_icon edit_subject ml-2"  data-id="{{ $subject->id }}"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</span>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-0" id="subdetail">
					<div id="sub_view_div"></div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- The Add Subject Modal -->
<div class="modal fade" id="addSubjectModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" name="addSubjectForm" id="addSubjectForm" role="form" enctype="multipart/form-data" autocomplete="off" data-parsley-validate data-parsley-trigger="keyup" data-parsley-trigger="focusout">
	            @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1">
                            <label for="unique-id-input" class="col-form-label">Subject Id<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="subject_id" id="subject_id" type="text" class="form-control" placeholder="SUB0001" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9][A-Za-z 0-9]*$"/>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="address-input" class="col-form-label">Subject Name<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="subject_name" id="subject_name" type="text" class="form-control" placeholder="Enter Subject Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9- .]*$"/>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="active-input" class="col-forwm-label">Is Active?</label>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <input type="checkbox" checked value="1" id="is_active" name="is_active" />
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Introduction  <span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-10">
                            <textarea  name="subject_intro" id="subject_intro" type="text" class="form-control" placeholder="Enter Introduction" required=""  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-maxlength="400" ></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Description</label>
                        </div>
                        <div class="col-lg-10">
                            <textarea  name="subject_description" id="subject_description" type="text" class="form-control" placeholder="Enter Description" ></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary" onclick="saveSubject();">
                </div>
	        </form>
        </div>
    </div>
</div>
<!-- End -->

<!-- The Edit Subject Modal -->
<div class="modal fade" id="subjectEditModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
	        <form method="post" name="updateSubjectForm" id="updateSubjectForm" role="form" enctype="multipart/form-data" autocomplete="off" data-parsley-validate>
	            @csrf
                <input  name="id" value="" id="id" type="hidden"  />
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1">
                            <label for="unique-id-input" class="col-form-label">Subject Id<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="subject_id" id="ed_subject_id" type="text" class="form-control" placeholder="SUB0001" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9][A-Za-z 0-9]*$"/>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="address-input" class="col-form-label">Subject Name<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="subject_name" id="ed_subject_name" type="text" class="form-control" placeholder="Enter Subject Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9- .]*$"/>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="active-input" class="col-forwm-label">Is Active?</label>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <input type="checkbox" checked value="1" id="ed_is_active" name="is_active" />
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Introduction  <span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-10">
                            <textarea  name="subject_intro" id="ed_subject_intro" type="text" class="form-control" placeholder="Enter Description" required=""  data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-maxlength="400" ></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Subject Description</label>
                        </div>
                        <div class="col-lg-10">
                            <textarea  name="subject_description" id="ed_subject_description" type="text" class="form-control" placeholder="Enter Subject Description" ></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" value="Update" name="submit" id="edit_submit" class="btn btn-primary" onclick="updateSubject();">
                </div>
	        </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<script type="text/javascript">
$(function () {
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
    $(".odtabs").not("#tab3").addClass('btn-outline-secondary');
	$("#tab3").addClass('btn-secondary');

    var table = $('#datatable').DataTable({
        responsive: true,
        dom: 'l<"toolbar">frtip',
        initComplete: function(){
		    $("div.toolbar").html('<button id="addSubject" type="button" class="ml-2 btn btn-primary" data-toggle="modal" data-target="#addSubjectModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Subject</button><br />');
		}, 
        'columnDefs': [ {
            'targets': [5],
            'orderable': false,
        }]
    });
    CKEDITOR.replace('subject_description');
});

function subjectStatus(value)
{
    window.location.href = '/subjectStatus/' + value;
}

function saveSubject() 
{
    if ($("#addSubjectForm").parsley()) {
        if ($("#addSubjectForm").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#addSubjectForm")[0]);
            var descValue = CKEDITOR.instances.subject_description.getData();
            formData.append("descriptionValue", descValue);
            if ($("#addSubjectForm").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('submit_subject') }}",
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

$(".edit_subject").click(function() 
{
    CKEDITOR.replace('ed_subject_description');
    var id = $(this).data('id');
    var url = '{{ route("edit_subject") }}';
    $.ajax({
        type: "post",
        url: url,
        data: { id:id , _token: '{{csrf_token()}}'},
        success: function(response)
        {
            var res =response.data[0];
            var desValue = res['subject_description'];
            var descriptionValue = CKEDITOR.instances.ed_subject_description.setData(desValue);
            $("#id").val(res['id']);
            $("#ed_subject_id").val(res['subject_id']);
            $("#ed_subject_name").val(res['subject_name']);
            $("#ed_subject_intro").val(res['subject_intro']);

            if(res['is_active'] == 1)
            {
                $( "#ed_is_active" ).attr('checked', 'checked');
            }
            else
            {
                $( "#ed_is_active" ).removeAttr('checked', 'checked');
            }
            $("#subjectEditModal").modal('show');
        }
    });
});

function updateSubject()
{
    var url = '{{ route("update_subject") }}';
    if ($("#updateSubjectForm").parsley()) {
		if ($("#updateSubjectForm").parsley().validate()) {
			event.preventDefault();
            var formData = new FormData($("#updateSubjectForm")[0]);
            $descriptionValue = CKEDITOR.instances.ed_subject_description.getData();
            formData.append("descriptionValue", $descriptionValue);
			if ($("#updateSubjectForm").parsley().isValid()) {
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
						location.reload();
					},
					error:function(response) {
						var errors = response.responseJSON;
						new PNotify({
                            title: 'Error',
                            text:  errors.msg,
                            type: 'error'
					    });
					}
				});
			}
		}
	}
}

function backTo_tble()
{
	$("#tbl_list").show();
	$("#subdetail").hide();
	$("#sub_view_div").html("");
}

function view_description(id)
{
	var url = '{{ route("sub_view") }}';
	$.ajax({
		type: "post",
		url: url,
		data: { id:id , _token: '{{csrf_token()}}'},
		dataType:'html',
		success: function(response)
		{
			$("#sub_view_div").html(response);
			$("#tbl_list").hide();
			$("#subdetail").show();
		}
	});  
}
</script>
@endsection