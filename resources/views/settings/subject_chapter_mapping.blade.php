@extends('layouts.app')
@section('title', 'Subject Chapter Mapping')

@section('content')
<style type="text/css">
     .bootstrap-duallistbox-container .buttons
  {
    background-color: #cccccc30!important;
  }
  .btn-default
  {
      border: 1px solid #cccccc33!important;
  }
</style>
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
                                <th>Course</th>
                                <th>Subject</th>
                                <th>Chapter</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             @forelse($mappings as $k=>$map)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>@if(isset($map->course)){{$map->course->course_name}} ({{$map->course->course_id}})@endif</td> 
                                <td>@if(isset($map->subject)){{$map->subject->subject_name}} ({{$map->subject->subject_id}})@endif</td>
                                <td>@if(isset($map->chapter)){{$map->chapter->chapter_name}} ({{$map->chapter->chapter_id}})@endif</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"  class="custom-control-input" id="customSwitch{{ $map->id }}"  value="{{ $map->id }}" onclick="subject_chapter_mappingStatus(this.value)" @if($map->is_active==1) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{ $map->id }}">@if($map->is_active==1) Active @else Inactive @endif</label>
                                    </div>
                                </td>
                                <td> 
                                    <span class="edit_icon edit_mapping ml-2"  data-id="{{ $map->id }}"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</span>
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
            <form method="post" name="addMappingForm" id="addMappingForm" role="form"  autocomplete="off" data-parsley-validate data-parsley-trigger="keyup" data-parsley-trigger="focusout">
	            @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Subject Chapter Mapping</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1">
                            <label for="unique-id-input" class="col-form-label">Course<span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="course_id" id="course_id">
                                <option value="">Select Course</option>
                                @forelse($courses as $course)
                                    <option value="{{$course->id}}">{{$course->course_name}}</option>
                                    @empty
                                @endforelse
                            </select>                                        
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="unique-id-input" class="col-form-label">Subject<span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="subject_id" id="subject_id">
                                <option value="">Select Subject</option>
                            </select>                                        
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
                            <label for="address-input" class="col-form-label">Chapters<span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-lg-10 demo">
                            <select multiple="multiple" size="10" id="chapter_id" name="chapter_id[]" title="chapter_id[]" required="" >
                                @foreach($chapters as $chapter)
                                    <option value="{{ $chapter->id }}">{{ $chapter->chapter_name }}</option>
                                @endforeach
                            </select>  
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

<script src="{{asset('app-assets/assets/js/jquery.bootstrap-duallistbox.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/assets/css/bootstrap-duallistbox.css')}}">
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
    $(".odtabs").not("#tab9").addClass('btn-outline-secondary');
	$("#tab9").addClass('btn-secondary');

    $('.modal').on('hidden.bs.modal', function() {
		$(this).find('form')[0].reset();
        $('select[name="subject_id"]').empty();
        $('select[name="subject_id"]').append('<option value="">Select Subject</option>');
        $('[name="chapter_id[]"]').bootstrapDualListbox('refresh', true);
  	});
    
    var table = $('#datatable').DataTable({
        responsive: true,
        dom: 'l<"toolbar">frtip',
        initComplete: function(){
		    $("div.toolbar").html('<button id="addMapping" type="button" class="ml-2 btn btn-primary" data-toggle="modal" data-target="#addMappingModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Mapping</button><br />');
		}, 
        'columnDefs': [ {
            'targets': [5],
            'orderable': false,
        }]
    });

    var demo1 = $('select[name="chapter_id[]"]').bootstrapDualListbox({
        nonSelectedListLabel: 'Non-selected Chapters',
        selectedListLabel: 'Selected Chapters',
        moveOnSelect: false,
        moveAllLabel:"",
        removeAllLabel:"",
        removeSelectedLabel:""
    });

    $('select[name="course_id"]').on('change', function() {
        var course_id = $(this).val();
        if(course_id) {
            $.ajax({
                url: '/getsubject',
                data: { id:course_id , _token: '{{csrf_token()}}'},
                type: "GET",
                dataType: "json",
                success:function(data) {                      
                    $('select[name="subject_id"]').empty();
                    $('select[name="subject_id"]').append('<option value="">Select Subject</option>');
                    $.each(data, function(key, value) {
                        $('select[name="subject_id"]').append('<option value="'+ value.id +'">'+ value.subject_name +'</option>');
                    });
                }
            });
        }else{
            $('select[name="subject_id"]').empty();
        }
    });

    $("#subject_id").change(function()
    {
        var subjectId = $(this).val();
        var courseId = $('#course_id').val();

        if(subjectId != "")
        {
            $.ajax({
                type: "POST",
                url: "{{ route('get_sub_chapter_maped') }}",
                data: {subjectId:subjectId ,courseId:courseId,_token: '{{csrf_token()}}'},
                success: function(response) {
                    var dt = response.data;
                    $('[name="chapter_id[]"] option').prop('selected', false);
                    if(dt.length === 0 )
                    {
                        $('[name="chapter_id[]"] option').prop('selected', false);
                    }
                    else
                    {
                        $.each(dt, function (i, item) 
                        {
                            $('[name="chapter_id[]"] option[value="'+item+'"]').prop('selected', true);

                        });
                    }
                    $('[name="chapter_id[]"]').bootstrapDualListbox('refresh', true);
                }
            });
        }
    });
});

function subject_chapter_mappingStatus(value)
{
    window.location.href = '/subject_chapter_mappingStatus/' + value;
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
                    url: "{{ route('submit_chaptermapping') }}",
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
   
    var url = '{{ route("edit_chapter_mapping") }}';
    $.ajax({
        type: "post",
        url: url,
        data: { id:id , _token: '{{csrf_token()}}'},
        success: function(response)
        {
            $("#addMappingModal").modal('show');
            var res =response.data[0];
            $("#course_id").val(res['course_id']).change();
            var courseID = res['course_id'];
            var subjectID = res['subject_id'];
			if(courseID) {
				$.ajax({
					url: '/getsubject',
					data: { id:courseID , _token: '{{csrf_token()}}'},
					type: "GET",
					dataType: "json",
					success:function(data) {                      
						$("#subject_id").empty();
						$.each(data, function(key, value) {
                            if(value.id == subjectID)
							{
								$("#subject_id").append('<option value="'+ value.id +'" selected="selected"    >'+ value.subject_name +'</option>').change();
							}
							else
							{
                                $("#subject_id").append('<option value="'+ value.id +'">'+ value.subject_name +'</option>').change();
							}
						});
					}
				});
			} else {
				$('select[name="subject_id"]').empty();
			}

            if(res['is_active'] == 1)
            {
                $( "#is_active" ).attr('checked', 'checked');
            }
            else
            {
                $( "#is_active" ).removeAttr('checked', 'checked');
            }
        }
    });
});
</script>
@endsection