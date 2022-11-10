@extends('layouts.app')
@section('title', 'Course')
@section('content')
<div class="container-fluid mt-1">
    @include('settings.common_tabs')
    <div class="col-lg-12" >
        <div class="card" >
            <div class="card-body">
                <div class="p-0">
                    <table id="datatable" class="table table-bordered mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Course Id</th>
                                <th>Course Name</th>
                                <th>Course Duration</th>
                                <th>Course Price</th>
                                <th>Course Banner</th>
                                <th>Course Document</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $k=>$course)
                            <tr style="cursor:pointer" onclick="window.location='{{route('detailsview',[Crypt::encrypt($course->id)])}}'">
                                <td>{{++$k}}</td>
                                <td>{{$course->course_id}}</td>
                                <td>{{$course->course_name}}</td>
                                <td>{{$course->course_duration}}</td>
                                <td>{{$course->course_price}}</td>
                                <td>                                                    
                                    <button onClick="ReadBanner({{$course->id}})" type="button" class="btn btn-success btn-sm">View</button>
                                </td>
                                <td>                                                   
                                    <button onClick="ReadDocument({{$course->id}})" type="button" class="btn btn-primary btn-sm">View</button>
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"  class="custom-control-input" id="customSwitch{{ $course->id }}"  value="{{ $course->id }}" onclick="courseStatus(this.value)" @if($course->is_active==1) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{ $course->id }}">@if($course->is_active==1) Active @else Inactive @endif</label>
                                    </div>
                                </td>
                                <td> 
                                    <button type="button" class="edit_icon edit_course ml-2 btn btn-sm"  data-id="{{ $course->id }}" onclick="editCourse({{ $course->id }})"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</button>
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
<!-- The Add Course Modal -->
<div class="modal fade" id="addCourseModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" name="addCourseForm" id="addCourseForm" role="form" enctype="multipart/form-data" autocomplete="off" data-parsley-validate data-parsley-trigger="keyup" data-parsley-trigger="focusout">
	            @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row ">
                        <div class="col-lg-1">
                            <label for="unique-id-input" class="col-form-label">Course Id<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="course_id" id="course_id" type="text" class="form-control" placeholder="COURS-0001" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z _0-9][A-Za-z 0-9]*$"/>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="name-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Company Name<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="company_id" id="company_id">
                                <option value="">Select Company</option>
                                @forelse($company_list as $company)
                                <option value="{{$company->id}}"> {{$company->company_name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="address-input" class="col-form-label">Course Name<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="course_name" id="course_name" type="text" class="form-control" placeholder="Enter Course Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z ]*$"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1 pr-0">
                            <label for="city-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Course Duration <span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="course_duration" id="course_duration" type="text" class="form-control" placeholder="Enter Course Duration" required/>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="state-input" class="col-form-label">Course Price</label>
                        </div>
                        <div class="col-lg-3">
                            <input name="course_price" id="course_price" type="text" class="form-control" placeholder="Enter Course Price"  data-parsley-trigger="keyup" data-parsley-type="number" />
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="doc-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Course Document </label>
                        </div>
                        <div class="col-lg-3">
                            <input id="course_document" name="course_document" type="file" class="form-control" accept="image/*,.pdf" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg,pdf">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1 pr-0">
                            <label for="banner-input" class="col-form-label">Course Banner </label>
                        </div>
                        <div class="col-lg-3">
                            <input id="course_banner" name="course_banner" type="file" class="form-control" accept="image/*" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg">
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="active-input" class="col-forwm-label">Is Active?</label>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <input type="checkbox" checked value="1" id="is_active" name="is_active" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1 pr-0">
                            <label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Course Description <span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-10">
                            <textarea name="course_description" id="course_description" type="text" class="form-control" placeholder="Enter Course Description"></textarea>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-1 pr-0">
                            <label for="desc-input" class="col-forwm-label px-0 mx-0" style="width: 114%;text-align: left;">Course Deliverables <span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-10">
                            <textarea name="course_deliverables" id="course_deliverables" type="text" class="form-control" placeholder="Enter Course Deliverables"></textarea>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-1 pr-0">
                            <label for="desc-input">Course Eligibility <span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-10">
                            <textarea name="course_eligibility" id="course_eligibility" type="text" class="form-control" placeholder="Enter Course Eligibility"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary" onclick="saveCourse();">
                </div>
	        </form>
        </div>
    </div>
</div>
<!-- End -->

<!-- The Edit Course Modal -->
<div class="modal fade" id="courseEditModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
	        <form method="post" name="updateCourseForm" id="updateCourseForm" role="form" enctype="multipart/form-data" autocomplete="off" data-parsley-validate>
	            @csrf
                <input  name="id" value="" id="id" type="hidden"  />
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Course</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
    		        <div id="append_data"></div>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" value="Update" name="submit" id="edit_submit" class="btn btn-primary" onclick="courseUpdate();">
                </div>
	        </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Banner Modal -->
<div class="modal" id="bannerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Course Banner</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="append_image"></div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Document Modal -->
<div class="modal" id="documentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Course Document</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="append_doc"></div>
            </div>
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
    $(".odtabs").not("#tab6").addClass('btn-outline-secondary');
	$("#tab6").addClass('btn-secondary');

    var table = $('#datatable').DataTable({
        responsive: true,
        dom: 'l<"toolbar">frtip',
        initComplete: function(){
		    $("div.toolbar").html('<button id="addCourse" type="button" class="ml-2 btn btn-primary" data-toggle="modal" data-target="#addCourseModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Course</button><br />');
		}, 
        'columnDefs': [ {
            'targets': [6],
            'orderable': false,
        }]
    });
    CKEDITOR.replace('course_description');
    CKEDITOR.replace('course_deliverables');
    CKEDITOR.replace('course_eligibility');
});

function ReadBanner(value)
{
    event.stopPropagation();
    $("#removeData").remove();
    $.ajax({
        url: "/view_course_banner/" + value,
        success: function(data) {
            $("#append_image").append(data.data);
            $('#bannerModal').modal('show'); 
        }
    })
}

function ReadDocument(value)
{
    event.stopPropagation();
    $("#removeData").remove();
    $.ajax({
        url: "/view_course_document/" + value,
        success: function(data) {
            $("#append_doc").append(data.data);
            $('#documentModal').modal('show'); 
        }
    })
}

function courseStatus(value)
{
    event.stopPropagation();
    window.location.href = '/courseStatus/' + value;
}

function saveCourse() 
{
    if ($("#addCourseForm").parsley()) {
        if ($("#addCourseForm").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#addCourseForm")[0]);
            var descValue = CKEDITOR.instances.course_description.getData();
            var deliValue = CKEDITOR.instances.course_deliverables.getData();
            var eligValue = CKEDITOR.instances.course_eligibility.getData();
            formData.append("descriptionValue", descValue);
            formData.append("deliverableValue", deliValue);
            formData.append("eligibilityValue", eligValue);
            if ($("#addCourseForm").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('submit_course') }}",
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

function editCourse(courseId) 
{
    event.stopPropagation();
    $("#removeData").remove();
    $.ajax({
        url: "/edit_course/" + courseId,
        success: function(data) {
            $("#append_data").append(data.data);
            CKEDITOR.replace('ed_course_description');
            CKEDITOR.replace('ed_course_deliverables');
            CKEDITOR.replace('ed_course_eligibility');
            $('#courseEditModal').modal('show'); 
        }
    })
}

function courseUpdate()
{
    if ($("#updateCourseForm").parsley()) {
        if ($("#updateCourseForm").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#updateCourseForm")[0]);
            var descValue = CKEDITOR.instances.ed_course_description.getData();
            var deliValue = CKEDITOR.instances.ed_course_deliverables.getData();
            var eligValue = CKEDITOR.instances.ed_course_eligibility.getData();
            formData.append("descriptionValue", descValue);
            formData.append("deliverableValue", deliValue);
            formData.append("eligibilityValue", eligValue);
            if ($(updateCourseForm).parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('/update_course') }}",
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
    return false;
}
</script>
@endsection