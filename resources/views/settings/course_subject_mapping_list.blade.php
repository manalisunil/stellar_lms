@extends('layouts.app')
@section('title', 'Course Subject Mapping')

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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mappings as $k=>$map)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>@if(isset($map->course)){{$map->course->course_name}}@endif</td>
                                <td>@if(isset($map->subject)){{$map->subject->subject_name}}@endif</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"  class="custom-control-input" id="customSwitch{{ $map->id }}"  value="{{ $map->id }}" onclick="mappingStatus(this.value)" @if($map->is_active==1) checked @endif>
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
                            <label for="unique-id-input" class="col-form-label">Course<span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-lg-3">
                            <select required class="form-control" name="course_id" id="course_id" required >
                                <option value="">Select Course</option>
                               @forelse($cources as $course)
                                    <option value="{{$course->id}}"  >{{$course->course_name}}</option>
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
                    <div class="row">
                        <div class="col-lg-1 pr-0">
                            <label for="address-input" class="col-form-label">Subject<span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-lg-10 demo">
                            <select multiple="multiple" size="10" id="subject_id" name="subject_id[]" title="subject_id[]" required="" >
                                    
                                     @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
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

<!-- The Edit Mapping Modal -->

<!-- End Modal -->
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
    $(".odtabs").not("#tab7").addClass('btn-outline-secondary');
	$("#tab7").addClass('btn-secondary');

    $('.modal').on('hidden.bs.modal', function() {
		$(this).find('form')[0].reset();
         $('[name="subject_id[]"]').bootstrapDualListbox('refresh', true);
  	});
    
    var table = $('#datatable').DataTable({
        responsive: true,
        dom: 'l<"toolbar">frtip',
        initComplete: function(){
		    $("div.toolbar").html('<button id="addMapping" type="button" class="ml-2 btn btn-primary" data-toggle="modal" data-target="#addMappingModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Mapping</button><br />');
		}, 
        'columnDefs': [ {
            'targets': [4],
            'orderable': false,
        }]
    });

    var demo1 = $('select[name="subject_id[]"]').bootstrapDualListbox({
        nonSelectedListLabel: 'Non-selected Courses',
        selectedListLabel: 'Selected Courses',
        moveOnSelect: false,
        moveAllLabel:"",
        removeAllLabel:"",
        removeSelectedLabel:""
    });
    $("#course_id").change(function()
    {
        var sub_id = $(this).val();

        if(sub_id != "")
        {
         $.ajax({
                    type: "POST",
                    url: "{{ route('get_courses_maped') }}",
                    data: {sub_id:sub_id ,_token: '{{csrf_token()}}'},
                    success: function(response) {
                        var dt = response.data;
                        $('[name="subject_id[]"] option').prop('selected', false);
                        if(dt.length === 0 )
                        {
                            $('[name="subject_id[]"] option').prop('selected', false);
                        }
                        else
                        {
                            $.each(dt, function (i, item) 
                            {
                                $('[name="subject_id[]"] option[value="'+item+'"]').prop('selected', true);

                           });
                        }
                        $('[name="subject_id[]"]').bootstrapDualListbox('refresh', true);
                    }
                });
        }
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
            $("#addMappingModal").modal('show');
            var res =response.data[0];
            $("#course_id").val(res['course_id']).change();
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

// function updateMapping()
// {
//     var url = '{{ route("update_mapping") }}';
//     if ($("#updateMappingForm").parsley()) {
// 		if ($("#updateMappingForm").parsley().validate()) {
// 			event.preventDefault();
//             var formData = new FormData($("#updateMappingForm")[0]);
// 			if ($("#updateMappingForm").parsley().isValid()) {
// 				$.ajax({
// 					type: "POST",
// 					cache:false,
// 					async: false,
// 					url: url,
// 					data: formData,
// 					processData: false,
// 					contentType: false,
// 					success: function(response) {
//                         if(response.msg=="Mapping Already Exists!"){
//                             new PNotify({
//                             title: 'Error',
//                             text:  response.msg,
//                             type: 'error',
//                             delay: 1000
//                             });
//                             return false;
//                         } else {
//                             new PNotify({
//                             title: 'Success',
//                             text:  response.msg,
//                             type: 'success'
//                             });
//                             setTimeout(function(){  location.reload(); }, 1000);
//                         }
//                     },
// 					error:function(response) {
// 						var errors = response.responseJSON;
// 						new PNotify({
//                             title: 'Error',
//                             text:  errors.msg,
//                             type: 'error'
// 					    });
// 					}
// 				});
// 			}
// 		}
// 	}
// }
</script>
@endsection