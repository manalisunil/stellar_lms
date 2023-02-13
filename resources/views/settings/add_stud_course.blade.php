@extends('layouts.app')
@section('title', 'Course')
@section('content')
<div class="container-fluid mt-1">
    @include('settings.common_tabs')
    <div class="col-lg-12" >
         <div class="card">
            <div class="card-body">
                <div class="pl-2">
                    <h5 class="card-title m-0">
                        <a href="{{ route('course_list') }}" style="text-decoration:none;">
                            <img class="mensuicon" src="{{asset('app-assets/assets/images/backs.png')}}" style="width:1.3rem;height:1.3rem;margin-right: 10px;"></a>
                        Add Student Course Mapping
                   </h5>
                </div>
            </div>
       
        <div class="card">
            <div class="card-body tabborder">
                
                <div class="row p-2" >
                        <div class="col-lg-1">
                            <label for="unique-id-input" class="col-form-label">Student<span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="user_id" id="user_id" required >
                                <option value="">Select Student</option>
                               @forelse($students as $student)
                                    <option value="{{$student->id}}"  >{{$student->first_name}} {{$student->last_name}}</option>
                                    @empty
                                    @endforelse
                            </select>                                        
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="active-input" class="col-forwm-label">Is Active?</label>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <input type="checkbox" checked value="1" id="is_active" name="is_active" />
                        </div>
                </div>
                <div class="row p-2">
                        <div class="col-lg-1">
                            <label for="address-input" class="col-form-label">Courses<span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-lg-3">
                            <select  class="form-control" id="course_id" name="course_id[]" title="subject_id[]" >
                                    <option value="">Select Course</option>
                                     @foreach($cources as $cource)
                                    <option value="{{ $cource->id }}">{{ $cource->course_name }}</option>
                                @endforeach
                            </select>  
                        </div>
                </div>
                <div class="row p-2">
                        <div class="col-lg-1">
                            <label for="address-input" class="col-form-label">Courses<span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-lg-3">
                            
                        </div>
                </div>
            </div>
        </div>
         </div>
    </div>
</div>


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
   $(".odtabs").not("#tab8").addClass('btn-outline-secondary');
    $("#tab8").addClass('btn-secondary');

});
function backTo_tble()
{
	$("#tbl_list").show();
	$("#coursedetail").hide();
	$("#course_view_div").html("");
}


</script>
@endsection