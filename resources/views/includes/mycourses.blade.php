@extends('layouts.app')
@section('title', 'Chapter')
@section('content')
<style type="text/css">
   .left_menu[data-toggle].collapsed:before {
     content: '▶';
     font-size: 14px;
    /*color: #777;*/
  /*float: right;*/
   margin-left: 5px;
  
    
}
.left_menu[data-toggle]:not(.collapsed):before {
     content: "▼";
      font-size: 14px;
      /*color: #777;*/
      margin-left: 5px;
}
.side_menu
{
   font-size: 17px
}
.main_btn
{
  /* width: 10%;
   align-items: center;*/
   padding-right: 10px!important;
}

</style>
<div class="container-fluid mt-1">
   @include('includes.mycourses_tabs')
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
             <div class="row">
              <div class="col-2 collapse show d-md-flex bg-light pt-2 pl-0 min-vh-100" id="sidebar">
                  <ul class="nav flex-column flex-nowrap overflow-hidden">
                     <!--  <li class="nav-item">
                          <a class="nav-link text-truncate" href="#"><i class="fa fa-home"></i> <span class=" d-sm-inline">Overview</span></a>
                      </li> -->
                      
                      @if(isset($courses_subjects))
                       @forelse($courses_subjects as $s1=>$subjects)
                         <li class="nav-item">
                             <a class="nav-link  left_menu collapsed " href="#submenu1" data-toggle="collapse" data-target="#submenu{{$s1}}"><!-- <i class="fa fa-table"></i> --> <span class="font-weight-bold d-sm-inline side_menu">   {{$subjects->getSubject['subject_name']}}</span></a>
                             <div class="collapse" id="submenu{{$s1}}" aria-expanded="false">
                                 <ul class="flex-column pl-2 nav">
                                     <!-- <li class="nav-item"><a class="nav-link py-0" href="#"><span>Course1</span></a></li> -->
                                     @php $all_chapters = $chapters->where('subject_id',$subjects->subject_id); @endphp
                                         @if(count($all_chapters) > 0)
                                           @foreach($all_chapters as $ch=>$chpter)
                                              <li class="nav-item">
                                                  <a class="nav-link left_menu collapsed py-1 pl-4" href="#submenu1sub1" data-toggle="collapse" data-target="#submenu1sub{{$ch}}"><span class=""><!-- <i class="fa-regular fa-folder pr-1"></i> --> {{$chpter->chapter_name}}</span></a>
                                                  <div class="collapse" id="submenu1sub{{$ch}}" aria-expanded="false">
                                                      <ul class="flex-column nav pl-4">
                                                         @php $all_topics = $topic->where('chapter_id',$chpter->id);
                                                         @endphp
                                                         @if(count($all_topics) > 0)
                                                         @foreach($all_topics as $topc)
                                                          <li class="nav-item">
                                                              <a class="nav-link  p-1  pl-4 " onclick="get_topic_detail({{$topc->id}})" style="cursor:pointer;"><i class="fa-solid fa-file-lines pr-1"></i>
                                                                 {{$topc->topic_name}} </a>
                                                          </li>
                                                          @endforeach
                                                          @endif
                                                         
                                                      </ul>
                                                  </div>
                                              </li>
                                              @endforeach
                                     @endif
                                 </ul>
                             </div>
                         </li>
                         @empty
                      @endforelse
                      @endif
                   
                  </ul>
              </div>
              <div class="col-10 content">

                  <div id="right_side" class="d-none">
                     <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                           <li class="nav-item main_btn">
                           <a class="nav-link  active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Content</a>
                           </li>
                           <li class="nav-item main_btn">
                           <a class="nav-link " id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Question</a>
                           </li>
                     </ul>
                     <div class="tab-content" id="pills-tabContent">
                       <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                           <div id="topic_content">
                              
                           </div>
                        </div>
                       <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                           <div id="topic_question">
                              
                           </div>
                          
                       </div>
                      
                     </div>
                 </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Add Video Modal -->
<div class="modal fade" id="videoAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="addvideoform" name="addvideoform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="topic_id1" name="topic_id" value="">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Video Link</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Video Link <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
							<input required name="video_link" value="" id="video_link" type="text" class="form-control" placeholder="Enter Video Link" required />
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-5 mt-3">
							<input type="checkbox" checked value="1" id="is_active" name="is_active" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="saveVideo();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

<!-- Edit Video Modal -->
<div class="modal fade" id="videoEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="editvideoform" name="editvideoform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="video_edit_id" name="video_edit_id" value="">
                <input type="hidden" id="video_topic_id" name="video_topic_id" value="">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Video Link</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Video Link <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
							<input required name="video_link" value="" id="ed_video_link" type="text" class="form-control" placeholder="Enter Video Link" required />
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-5 mt-3">
							<input type="checkbox" checked value="1" id="ed_is_active" name="is_active" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="updateVideo();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

<!-- Add Document Modal -->
<div class="modal fade" id="documentAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="adddocumentform" name="adddocumentform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="topic_id2" name="topic_id" value="">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Document</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Document </label>
						</div>
						<div class="col-lg-4">
                            <input id="topic_document" name="topic_document" type="file" class="form-control" accept="image/*,.pdf" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg,pdf">
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-3 mt-3">
							<input type="checkbox" checked value="1" id="is_active" name="is_active" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="saveDocument();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

<!-- Add Content Modal -->
<div class="modal fade" id="contentAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="addcontentform" name="addcontentform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="topic_id3" name="topic_id" value="">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Content</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Content <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-10">
                            <textarea  name="content" id="content" type="text" class="form-control" placeholder="Enter content" ></textarea>
						</div>
                    </div>
                    <div class="row mt-1">
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-3 mt-3">
							<input type="checkbox" checked value="1" id="is_active" name="is_active" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="saveContent();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

<!-- Edit Content Modal -->
<div class="modal fade" id="contentEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="editcontentform" name="editcontentform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="content_edit_id" name="content_edit_id" value="">
                <input type="hidden" id="content_topic_id" name="content_topic_id" value="">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Content</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Content <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-10">
                            <textarea  name="content" id="ed_content" type="text" class="form-control" placeholder="Enter content" ></textarea>
						</div>
                    </div>
                    <div class="row mt-1">
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-3 mt-3">
							<input type="checkbox" checked value="1" id="ed_is_active1" name="is_active" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="updateContent();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

<!-- Edit Document Modal -->
<div class="modal fade" id="documentEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="editdocumentform" name="editdocumentform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="doc_edit_id" name="doc_edit_id" value="">
                <input type="hidden" id="doc_topic_id" name="doc_topic_id" value="">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Document</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Document </label>
						</div>
						<div class="col-lg-4">
                            <input id="ed_topic_document" name="topic_document" type="file" class="form-control" accept="image/*,.pdf" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg,pdf">
						</div>
						<div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-3 mt-3">
							<input type="checkbox" checked value="1" id="ed_is_active2" name="is_active" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="updateDocument();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

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
    CKEDITOR.replace('content');
});


function get_topic_content(id)
{
   $.ajax({
           type: "POST",
           url: "{{ route('get_topic_detail') }}",
           data: { id:id , _token: '{{csrf_token()}}'},
           success: function(response) 
           {
               $("#right_side").removeClass('d-none');
               $("#topic_content").html(response);
           }
        });
}
function get_topic_detail(id)
{
   get_topic_content(id);
   get_topic_question(id);
}
function get_topic_question(id)
{
   $.ajax({
           type: "POST",
           url: "{{ route('get_topic_question') }}",
           data: { id:id , _token: '{{csrf_token()}}'},
           success: function(response) 
           {
               $("#right_side").removeClass('d-none');
               $("#topic_question").html(response);
           }
        });
}

$('#videoAddModal').on('shown.bs.modal', function () {
    var id1 = $('#video_id').data('id');
    $("#topic_id1").val(id1);
});

$('#documentAddModal').on('shown.bs.modal', function () {
    var id2 = $('#doc_id').data('id');
    $("#topic_id2").val(id2);
});

$('#contentAddModal').on('shown.bs.modal', function () {
    var id3 = $('#content_id').data('id');
    $("#topic_id3").val(id3);
});

function saveVideo() 
{
    if($("#addvideoform").parsley()) {
        if ($("#addvideoform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#addvideoform")[0]);
            if($("#addvideoform").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('add_video_link') }}",
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

function editVideo(id)
{
    var id = $('#edit_video'+id).data('id');
    var topic_id = $('#edit_video'+id).data('topic-id');
    var link = $('#edit_video'+id).data('video-link');
    var status = $('#edit_video'+id).data('is-active');
    $("#video_edit_id").val(id);
    $("#video_topic_id").val(topic_id);
    $("#ed_video_link").val(link);
    if(status == 1)
    {
        $( "#ed_is_active" ).attr('checked', 'checked');
    }
    else
    {
        $( "#ed_is_active" ).removeAttr('checked', 'checked');
    }
    $("#videoEditModal").modal('show');
}

function updateVideo()
{
    if ($("#editvideoform").parsley()) {
        if ($("#editvideoform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#editvideoform")[0]);
            if ($("#editvideoform").parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('/edit_video_link') }}",
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

function saveContent() 
{
    if($("#addcontentform").parsley()) {
        if ($("#addcontentform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#addcontentform")[0]);
            var contentValue = CKEDITOR.instances.content.getData();
            formData.append("contentvalue", contentValue);
            if($("#addcontentform").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('add_content') }}",
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

function editContent(id)
{
    CKEDITOR.replace('ed_content');
    var id = $('#edit_content'+id).data('id');
    var topic_id = $('#edit_content'+id).data('topic-id');
    var status = $('#edit_content'+id).data('is-active');
    var content = $('#edit_content'+id).data('content');
    $("#content_edit_id").val(id);
    $("#content_topic_id").val(topic_id);
    var contValue = content;
    var contentValue = CKEDITOR.instances.ed_content.setData(contValue);
    if(status == 1)
    {
        $("#ed_is_active1").attr('checked', 'checked');
    }
    else
    {
        $("#ed_is_active1").removeAttr('checked', 'checked');
    }
    $("#contentEditModal").modal('show');
}

function updateContent()
{
    if ($("#editcontentform").parsley()) {
        if ($("#editcontentform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#editcontentform")[0]);
            var value = CKEDITOR.instances.ed_content.getData();
            formData.append("contentValue", value);
            if ($("#editcontentform").parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('/edit_content') }}",
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

function saveDocument() 
{
    if($("#adddocumentform").parsley()) {
        if ($("#adddocumentform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#adddocumentform")[0]);
            if($("#adddocumentform").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('/add_document') }}",
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

function editDocument(id)
{
    var id = $('#edit_document'+id).data('id');
    var topic_id = $('#edit_document'+id).data('topic-id');
    var status = $('#edit_document'+id).data('is-active');
    $("#doc_edit_id").val(id);
    $("#doc_topic_id").val(topic_id);
    if(status == 1)
    {
        $("#ed_is_active2").attr('checked', 'checked');
    }
    else
    {
        $("#ed_is_active2").removeAttr('checked', 'checked');
    }
    $("#documentEditModal").modal('show');
}

function updateDocument()
{
    if ($("#editdocumentform").parsley()) {
        if ($("#editdocumentform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#editdocumentform")[0]);
            if ($("#editdocumentform").parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('/edit_document') }}",
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