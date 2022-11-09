@extends('layouts.app')
@section('title', 'Course Subject Mapping')
@section('content')
<div class="container-fluid mt-1">
    <div class="col-lg-12" >
        <div class="card" >
            <div class="card-body">
                <div class="p-0">
                    <table id="datatable" class="table table-bordered mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mappings as $map)
                            <tr>
                                <td>@if(isset($map->course)){{$map->course->course_name}}@endif</td>
                                <td>@if(isset($map->subject)){{$map->subject->subject_name}}@endif</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"  class="custom-control-input" id="customSwitch{{ $map->id }}"  value="{{ $map->id }}" onclick="mappingStatus(this.value)" @if($map->is_active==1) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{ $map->id }}">@if($map->is_active==1) Active @else Inactive @endif</label>
                                    </div>
                                </td>
                                <td> 
                                    <button type="button" class="edit_icon edit_mapping ml-2 btn btn-sm"  data-id="{{ $map->id }}"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</button>
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
<!-- The Add Mapping Modal -->
<div class="modal fade" id="addMappingModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" name="addMappingForm" id="addMappingForm" role="form" enctype="multipart/form-data" autocomplete="off" data-parsley-validate data-parsley-trigger="keyup" data-parsley-trigger="focusout">
	            @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Course Subject Mapping</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1">
                            <label for="unique-id-input" class="col-form-label">Subject<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="subject_id" id="subject_id" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>                                        
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="address-input" class="col-form-label">Course<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="course_id" id="course_id" required>
                                <option value="">Select Course</option>
                                @foreach($cources as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>    
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="active-input" class="col-forwm-label">Is Active?</label>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <input type="checkbox" checked value="1" id="is_active" name="is_active" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary" onclick="saveMapping();">
                </div>
	        </form>
        </div>
    </div>
</div>
<!-- End -->

<!-- The Edit Mapping Modal -->
<div class="modal fade" id="mappingEditModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
	        <form method="post" name="updateMappingForm" id="updateMappingForm" role="form" enctype="multipart/form-data" autocomplete="off" data-parsley-validate>
	            @csrf
                <input  name="id" value="" id="id" type="hidden"  />
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Course Subject Mapping</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1">
                            <label for="unique-id-input" class="col-form-label">Subject<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="subject_id" id="ed_subject_id" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>                                        
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="address-input" class="col-form-label">Course<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="course_id" id="ed_course_id" required>
                                <option value="">Select Course</option>
                                @foreach($cources as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>    
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="active-input" class="col-forwm-label">Is Active?</label>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <input type="checkbox" checked value="1" id="ed_is_active" name="is_active" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" value="Update" name="submit" id="edit_submit" class="btn btn-primary" onclick="updateMapping();">
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
    var table = $('#datatable').DataTable({
        responsive: true,
        dom: 'l<"toolbar">frtip',
        initComplete: function(){
		    $("div.toolbar").html('<button id="addMapping" type="button" class="ml-2 btn btn-primary" data-toggle="modal" data-target="#addMappingModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Mapping</button><br />');
		}, 
        'columnDefs': [ {
            'targets': [3],
            'orderable': false,
        }]
    });
});

function mappingStatus(value)
{
    window.location.href = '/mappingStatus/' + value;
}

function saveMapping() {
    if ($("#addMappingForm").parsley()) {
        if ($("#addMappingForm").parsley().validate()) {
            event.preventDefault();
            if ($("#addMappingForm").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('submit_csmapping') }}",
                    data: new FormData($("#addMappingForm")[0]),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.msg=="Mapping Already Exists!"){
                            new PNotify({
                            title: 'Error',
                            text:  response.msg,
                            type: 'error',
                            delay: 1000
                            });
                            return false;
                        } else {
                            new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success'
                            });
                            setTimeout(function(){  location.reload(); }, 1000);
                        }
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

$(".edit_mapping").click(function() {
    var id = $(this).data('id');
    var url = '{{ route("edit_mapping") }}';
    $.ajax({
        type: "post",
        url: url,
        data: { id:id , _token: '{{csrf_token()}}'},
        success: function(response)
        {
            var res =response.data[0];
            $("#id").val(res['id']);
            $("#ed_subject_id").val(res['subject_id']);
            $("#ed_course_id").val(res['course_id']);
            if(res['is_active'] == 1)
            {
                $( "#ed_is_active" ).attr('checked', 'checked');
            }
            else
            {
                $( "#ed_is_active" ).removeAttr('checked', 'checked');
            }
            $("#mappingEditModal").modal('show');
        }
    });
});

function updateMapping()
{
    var url = '{{ route("update_mapping") }}';
    if ($("#updateMappingForm").parsley()) {
		if ($("#updateMappingForm").parsley().validate()) {
			event.preventDefault();
            var formData = new FormData($("#updateMappingForm")[0]);
			if ($("#updateMappingForm").parsley().isValid()) {
				$.ajax({
					type: "POST",
					cache:false,
					async: false,
					url: url,
					data: formData,
					processData: false,
					contentType: false,
					success: function(response) {
                        if(response.msg=="Mapping Already Exists!"){
                            new PNotify({
                            title: 'Error',
                            text:  response.msg,
                            type: 'error',
                            delay: 1000
                            });
                            return false;
                        } else {
                            new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success'
                            });
                            setTimeout(function(){  location.reload(); }, 1000);
                        }
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
</script>
@endsection