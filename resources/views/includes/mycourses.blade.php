@extends('layouts.app')
@section('title', 'Chapter')
@section('content')
<style type="text/css">
  .nav-link.left_menu[data-toggle].collapsed:before {
     content: '▶';
     font-size: 14px;
    /*color: #777;*/
  /*float: right;*/
   margin-left: 5px;
  
    
}
/*.left_menu[data-toggle]not(.collapsed):before*/
.nav-link.left_menu[aria-expanded="true"]::before
{
    content: "▼";
    font-size: 14px;
      color: #2a39ff;
    margin-left: 5px;
}
.nav-link.left_menu[aria-expanded="true"] span
{
	 color: #2a39ff;
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
.left_buttons
{
	position: relative;
	margin-top:-2% !important;
}
.lbl
{
	font-weight: bold;
	font-size: 13px !important;
}
.lbl_text
{
	font-size: 13px !important;
}
.active_topic
{
	color: #f68c1e !important;
	font-weight: bold;
}

</style>
<div class="container-fluid mt-1">
   @include('includes.mycourses_tabs')
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
             <div class="row">
              <div class="col-2 collapse show d-md-flex bg-light pt-2 pl-0 min-vh-100" id="sidebar">
                  <ul class="nav  flex-column flex-nowrap overflow-hidden">
                     <!--  <li class="nav-item">
                          <a class="nav-link text-truncate" href="#"><i class="fa fa-home"></i> <span class=" d-sm-inline">Overview</span></a>
                      </li> -->
                      
                      @if(isset($courses_subjects))
                       @forelse($courses_subjects as $s1=>$subjects)
                         <li class="nav-item">
                             <a class="nav-link  left_menu collapsed " href="submenu{{$s1}}" data-toggle="collapse" data-target="#submenu{{$s1}}"><!-- <i class="fa fa-table"></i> --> <span class="font-weight-bold d-sm-inline side_menu">   {{$subjects->getSubject['subject_name']}}</span></a>
                             <div class="collapse" id="submenu{{$s1}}" aria-expanded="false">
                                 <ul class="flex-column pl-2 nav">
                                     <!-- <li class="nav-item"><a class="nav-link py-0" href="#"><span>Course1</span></a></li> -->
                                     @php $all_chapters = $subject_chapters->where('subject_id',$subjects->subject_id)->where('is_active',1); @endphp 
                                         @if(count($all_chapters) > 0)
                                           @foreach($all_chapters as $ch=>$chpter)
                                              <li class="nav-item">
                                                  <a class="nav-link left_menu collapsed py-1 pl-4" href="#submenu1sub{{$ch}}" data-toggle="collapse" data-target="#submenu1sub{{$ch}}"><span class="chapter-lbl" data-title="{{$chpter->chapter->chapter_name}}"><!-- <i class="fa-regular fa-folder pr-1"></i> -->  {{ substr($chpter->chapter->chapter_name, 0,28)}}...</span></a>
                                                  <div class="collapse" id="submenu1sub{{$ch}}" aria-expanded="false">
                                                      <ul class="flex-column nav pl-4">
                                                         @php $all_topics = $topic->where('chapter_id',$chpter->chapter->id)->where('is_active',1);
                                                         @endphp
                                                         @if(count($all_topics) > 0)
                                                         @foreach($all_topics as $topc)
                                                          <li class="nav-item">
                                                              <a class="nav-link  p-1  pl-5 topic_nm" id="top_{{$topc->id}}"  onclick="get_topic_detail({{$topc->id}})" style="cursor:pointer;"><i class="fa-solid fa-file-lines pr-1"></i>
                                                              	{{ substr($topc->topic_name, 0,40)}}
                                                                  </a>
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

                  <div id="right_side" class="d-none ">
                  	<div class="row">
	                  	<div class="col-md-8">
	                  		<input type="hidden" name="current_topic_id" id="current_topic_id" value="">
		                    <ul class="mycourse_link nav nav-pills mb-3" id="pills-tab" role="tablist">
	                           <li class="nav-item main_btn">
		                           <a class="nav-link  active" id="pills-home-tab" data-toggle="pill" href="#content_tab" role="tab" aria-controls="pills-home" aria-selected="true">Content</a>
	                           </li>
	                           <li class="nav-item main_btn">
		                           <a class="nav-link " id="pills-profile-tab" data-toggle="pill" href="#question_tab" role="tab" aria-controls="pills-profile" aria-selected="false">Question</a>
	                           </li>
		                    </ul>
	                 	</div>
	                 	<div class="col-md-4 btn-test">
	                 		 <div class="left_buttonss pr-4" id="button_content_tab">
            						
				                    <button class="mx-1 btn btn-sm btn-primary course_btns" id="video_id" data-toggle="modal" data-id="" data-target="#videoAddModal">Add Video Link</button>
				                    <button class="mx-1 btn btn-sm btn-primary course_btns" id="doc_id" data-toggle="modal" data-id="" data-target="#documentAddModal">Add Document</button>
				                    <button class="mx-1 btn btn-sm btn-primary course_btns" id="content_id" data-toggle="modal" data-id="" data-target="#contentAddModal">Add Content</button>
				             </div>
				             <div class="left_buttonss d-none pr-4" id="button_question_tab">
            	
				                    <button class="mx-1 btn btn-sm btn-primary course_btns" id="mcq_id" data-toggle="modal" data-id="" data-target="#mcqAddModal">Add MCQ</button>
									<button class="mx-1 btn btn-sm btn-primary course_btns" id="tof_id" data-toggle="modal" data-id="" data-target="#tofAddModal">Add True/False</button>
				             </div>
	                 	</div>
	                 </div>
                     <div class="tab-content" id="pills-tabContent">
                       <div class="tab-pane fade show active" id="content_tab" role="tabpanel" aria-labelledby="pills-home-tab">
                           <div id="topic_content">
                              
                           </div>
                        </div>
                       <div class="tab-pane fade" id="question_tab" role="tabpanel" aria-labelledby="pills-profile-tab">
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
							<input required name="video_link" value="" id="video_link" type="url" class="form-control" placeholder="Enter Video Link" required  data-parsley-type="url"/>
						</div>
						<div class="col-lg-2 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Thumbnail Image </label> 
						</div>
						<div class="col-lg-4 ">
							  <input id="thumbnail_img" name="thumbnail_img" type="file" class="form-control" accept="image/*," data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg">
						</div>
						
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Video Name <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
							<input required name="video_name" value="" id="video_name" type="text" class="form-control" placeholder="Enter Video name" required />
						</div>
						<div class="col-lg-2 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-4 mt-3">
							<input type="checkbox" checked value="1" id="is_active" name="is_active" />
						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" id="submit_video" class="btn btn-primary" onclick="saveVideo();">Submit</button>
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
							<input required name="video_link" value="" id="ed_video_link" type="url" class="form-control" placeholder="Enter Video Link" required data-parsley-type="url" />
						</div>
						<div class="col-lg-2 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Thumbnail Image </label> 
						</div>
						<div class="col-lg-4 ">
							  <input id="thumbnail_img" name="thumbnail_img" type="file" class="form-control" accept="image/*," data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg">
						</div>
						
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Video Name <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
							<input required name="video_name" value="" id="ed_video_name" type="text" class="form-control" placeholder="Enter Video name" required />
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
							<label for="company_select" class="col-form-label"> Document <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-4">
                            <input id="topic_document" name="topic_document" type="file" class="form-control" accept="image/*,.pdf" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg,pdf" required="">
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
					<button type="submit" class="btn btn-primary" id="submitDoc" onclick="saveDocument();">Submit</button>
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
					<button type="submit" id="submitContent" class="btn btn-primary" onclick="saveContent();">Submit</button>
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
                            <input id="ed_topic_document" name="topic_document" type="file" class="form-control" accept="image/*,.pdf" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg,pdf" required="">
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

<!-- View Document Modal -->
<div class="modal" id="documentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">View Document</h5>
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

<!-- Add MCQ Modal -->
<div class="modal fade" id="mcqAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="addmcqform" name="addmcqform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="topic_id5" name="topic_id" value="">
                <input type="hidden" id="type_id" name="type_id" value="1">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add MCQ</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Question <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-11">
                            <textarea  name="question" id="question" type="text" class="form-control" placeholder="Enter Question" required></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
						<div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Option 1 <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <textarea  name="opt1" id="opt1" type="text" class="form-control" placeholder="Enter Option 1" required></textarea>
						</div>
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Option 2 <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <textarea  name="opt2" id="opt2" type="text" class="form-control" placeholder="Enter Option 2" required></textarea>
						</div>
					</div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Option 3 <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <textarea  name="opt3" id="opt3" type="text" class="form-control" placeholder="Enter Option 3" required></textarea>
						</div>
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Option 4 <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <textarea  name="opt4" id="opt4" type="text" class="form-control" placeholder="Enter Option 4" required></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Correct Answer <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <select required class="form-control" name="answer" id="answer">
								<option value="" selected disabled>Select Correct Option</option>
                                <option value="1" >Option 1</option>
                                <option value="2" >Option 2</option>
                                <option value="3" >Option 3</option>
                                <option value="4" >Option 4</option>
							</select>	
						</div>
                        <div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Tags </label> 
						</div>
						<div class="col-lg-5">
                            <textarea  name="tags" id="tags" type="text" class="form-control" placeholder="Enter Tags (comma separated values)" ></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label"> Reason <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-11">
                            <textarea  name="reason" id="reason" type="text" class="form-control" placeholder="Enter Reason" required></textarea>
						</div>
					</div>
                    <div class="row mt-2">
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
					<button type="submit" class="btn btn-primary" id="submitmcq" onclick="saveMCQ();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

<!-- Edit MCQ Modal -->
<div class="modal fade" id="mcqEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="editmcqform" name="editmcqform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="mcq_edit_id" name="mcq_edit_id" value="">
                <input type="hidden" id="mcq_topic_id" name="mcq_topic_id" value="">
                  <input type="hidden" id="type_id" name="type_id" value="1">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit MCQ</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Question <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-11">
                            <textarea  name="question" id="ed_question" type="text" class="form-control" placeholder="Enter Question" required></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
						<div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Option 1 <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <textarea  name="opt1" id="ed_opt1" type="text" class="form-control" placeholder="Enter Option 1" required></textarea>
						</div>
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Option 2 <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <textarea  name="opt2" id="ed_opt2" type="text" class="form-control" placeholder="Enter Option 2" required></textarea>
						</div>
					</div>
                    <div class="row mt-1">
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Option 3 <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <textarea  name="opt3" id="ed_opt3" type="text" class="form-control" placeholder="Enter Option 3" required></textarea>
						</div>
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Option 4 <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <textarea  name="opt4" id="ed_opt4" type="text" class="form-control" placeholder="Enter Option 4" required></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
						<div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Correct Answer <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5">
                            <select required class="form-control" name="answer" id="ed_answer">
								<option value="" selected disabled>Select Correct Option</option>
                                <option value="1" >Option 1</option>
                                <option value="2" >Option 2</option>
                                <option value="3" >Option 3</option>
                                <option value="4" >Option 4</option>
							</select>	
						</div>
                        <div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Tags </label> 
						</div>
						<div class="col-lg-5">
                            <textarea  name="tags" id="ed_tags" type="text" class="form-control" placeholder="Enter Tags (comma separated values)" ></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label"> Reason <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-11">
                            <textarea  name="reason" id="ed_reason" type="text" class="form-control" placeholder="Enter Reason" required></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-5 mt-3">
							<input type="checkbox" checked value="1" id="ed_mcq_is_active" name="is_active" />
						</div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="updateMcq();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

<!-- Add True or False Modal -->
<div class="modal fade" id="tofAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="addtofform" name="addtofform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="topic_id4" name="topic_id" value="">
                 <input type="hidden" id="type_id" name="type_id" value="2">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add True Or False</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Question <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-11">
                            <textarea  name="question" id="question" type="text" class="form-control" placeholder="Enter Question" required></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
						<div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Correct Answer <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5 mt-3">
                            <input type="radio" id="answer" name="answer" value="1" checked>True &nbsp;&nbsp;
							<input type="radio" id="answer" name="answer" value="2" >False	
						</div>
                        <div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Tags </label> 
						</div>
						<div class="col-lg-5">
                            <textarea  name="tags" id="tags" type="text" class="form-control" placeholder="Enter Tags (comma separated values)" ></textarea>
						</div>
					</div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label"> Reason <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-11">
                            <textarea  name="reason" id="reason" type="text" class="form-control" placeholder="Enter Reason" required></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
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
					<button type="submit" class="btn btn-primary" id="submittfque" onclick="saveTrueOrFalse();">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End  Modal -->

<!-- Edit True or False Modal -->
<div class="modal fade" id="tofEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form method="post" id="edittofform" name="edittofform"  data-parsley-validate data-parsley-trigger="keyup">
			@csrf
                <input type="hidden" id="tof_edit_id" name="tof_edit_id" value="">
                <input type="hidden" id="tof_topic_id" name="tof_topic_id" value="">
                 <input type="hidden" id="type_id" name="type_id" value="2">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit True Or False</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <div class="row">
						<div class="col-lg-1 pr-0">
							<label for="company_select" class="col-form-label"> Question <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-11">
                            <textarea  name="question" id="ed_tf_question" type="text" class="form-control" placeholder="Enter Question" required></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
						<div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Correct Answer <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-5 mt-3">
                            <input type="radio" id="ed_tf_answer" name="answer" value="1" >True &nbsp;&nbsp;
							<input type="radio" id="ed_tf_answer" name="answer" value="2" >False	
						</div>
                        <div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Tags </label> 
						</div>
						<div class="col-lg-5">
                            <textarea  name="tags" id="ed_tf_tags" type="text" class="form-control" placeholder="Enter Tags (comma separated values) " ></textarea>
						</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="company_select" class="col-form-label"> Reason <span class="text-danger"> * </span></label>
						</div>
						<div class="col-lg-11">
                            <textarea  name="reason" id="ed_tf_reason" type="text" class="form-control" placeholder="Enter Reason" required></textarea>
						</div>
					</div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
							<label for="example-email-input" class="col-form-label pr-3">Status </label> 
						</div>
						<div class="col-lg-3 mt-3">
							<input type="checkbox" checked value="1" id="ed_tf_is_active" name="is_active" />
						</div>
                    </div>
                </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="updateTrueOrFalse();">Submit</button>
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
    $('.modal').on('hidden.bs.modal', function() {
		$(this).find('form')[0].reset();
        $(this).find('form').parsley().reset();
        $(this).removeData('bs.modal');
		var frmName = $(this).find('form')[0].name;
		if(frmName == "addcontentform")
		{
			CKEDITOR.instances['content'].setData('');
		}
  	});
    
    CKEDITOR.on("instanceReady", function(event) {
        event.editor.on("beforeCommandExec", function(event) {
            // Show the paste dialog for the paste buttons and right-click paste
            if (event.data.name == "paste") {
                event.editor._.forcePasteDialog = true;
            }
            // Don't show the paste dialog for Ctrl+Shift+V
            if (event.data.name == "pastetext" && event.data.commandData.from == "keystrokeHandler") {
                event.cancel();
            }
        })
    });
    CKEDITOR.replace('content');
});


function viewDocument(value)
{
    event.stopPropagation();
    $("#removeData").remove();
    $.ajax({
        url: "/view_mycourse_document/" + value,
        success: function(data) {
            $("#append_doc").append(data.data);
            $('#documentModal').modal('show'); 
        }
    })
} 

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
	$('#current_topic_id').val(id);
	$(".course_btns").attr('data-id',id);
	$(".topic_nm").removeClass('active_topic');
	$("#top_"+id).addClass('active_topic');
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
                var table1 = $('#mcq_table').DataTable({
                    responsive: true
                });
                var table2 = $('#tof_table').DataTable({
                    responsive: true
                });
            }
        });
}
$('.mycourse_link li a').click(function(){

	var data = $(this).attr("href");
	if(data ==="#question_tab")
	{
		$("#button_question_tab").removeClass('d-none');
		$("#button_content_tab").addClass('d-none');
	}
	else
	{
		$("#button_question_tab").addClass('d-none');
		$("#button_content_tab").removeClass('d-none');
	}

	// console.log(data);

});

$('#videoAddModal').on('shown.bs.modal', function () {
	var id1 = $('#current_topic_id').val();
    // var id1 = $('#video_id').data('id');
    $("#topic_id1").val(id1);
});

$('#documentAddModal').on('shown.bs.modal', function () {
	$("#submitDoc").html('Submit').attr("disabled", false);
    var id2 = $('#current_topic_id').val();
    $("#topic_id2").val(id2);
});

$('#contentAddModal').on('shown.bs.modal', function () {
		
  $("#submitContent").html('Submit').attr("disabled", false);
    var id3 = $('#current_topic_id').val();
    $("#topic_id3").val(id3);
});

$('#tofAddModal').on('shown.bs.modal', function () {
	$("#submittfque").html('Submit').attr("disabled", false);
    var id4 = $('#current_topic_id').val();
    $("#topic_id4").val(id4);
});

$('#mcqAddModal').on('shown.bs.modal', function () {
	$("#submitmcq").html('Submit').attr("disabled", false);
    var id5 = $('#current_topic_id').val();
    $("#topic_id5").val(id5);
});

function saveVideo() 
{
    var id = $('#topic_id1').val();
    if($("#addvideoform").parsley()) {
        if ($("#addvideoform").parsley().validate()) {
            event.preventDefault();
              $("#btnSubmit").attr("disabled", true);
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
                    beforeSend: function(){
					$('#submit_video').html("<i class='bx bx-loader-circle bx-spin bx-flip-horizontal' ></i>Please Wait!");
					},
                    success: function(response) {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#videoAddModal').modal('hide');
                        $('#addvideoform')[0].reset();
                        get_topic_content(id);
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
                    },
                    complete: function() {
				        $("#submit_video").html('Submit');
				    },
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
    var video_name = $('#edit_video'+id).data('video_name');
    
    $("#video_edit_id").val(id);
    $("#video_topic_id").val(topic_id);
    $("#ed_video_link").val(link);
    $("#ed_video_name").val(video_name);
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
    var id = $('#video_topic_id').val();
    if ($("#editvideoform").parsley()) {
        if ($("#editvideoform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#editvideoform")[0]);
            if ($("#editvideoform").parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('mycourses/edit_video_link') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#videoEditModal').modal('hide');
                        $('#editvideoform')[0].reset();
                        get_topic_content(id);
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
    var id=$('#topic_id3').val();
    if($("#addcontentform").parsley()) {
        if ($("#addcontentform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#addcontentform")[0]);
            var contentValue = CKEDITOR.instances.content.getData();
            formData.append("contentvalue", contentValue);
              console.log(contentValue);
            if($("#addcontentform").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('add_content') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
					$('#submitContent').html("Please Wait..").attr("disabled", true);
					},
                    success: function(response) {

                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#contentAddModal').modal('hide');
                        $('#addcontentform')[0].reset();
                        get_topic_content(id);
                        CKEDITOR.instances['content'].setData('');
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
                        $("#submitContent").html('Submit').attr("disabled", false);
                    },
                    complete: function() {
                    	
                    	$("#submitContent").html('Submit').attr("disabled", false);
				       
				    },
                });
            }
        }
    }
} 

function editContent(id)
{
	var id = $('#edit_content'+id).data('id');
    var topic_id = $('#edit_content'+id).data('topic-id');
    var status = $('#edit_content'+id).data('is-active');
    $("#content_edit_id").val(id);
    $("#content_topic_id").val(topic_id);
  
    if(status == 1)
    {
        $("#ed_is_active1").attr('checked', 'checked');
    }
    else
    {
        $("#ed_is_active1").removeAttr('checked', 'checked');
    }

	   var url = '{{ route("edit_content") }}';
	   CKEDITOR.replace('ed_content');
	$.ajax({
		type: "post",
		url: url,
		data: { id:id , _token: '{{csrf_token()}}'},
		dataType:'json',
		success: function(response)
		{

			  var contentValue = CKEDITOR.instances.ed_content.setData(response.data);
			  
			  
			    $("#contentEditModal").modal('show');
					}
	});
  
    
}

function updateContent()
{
    var id=$('#content_topic_id').val();
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
                    url: "{{ url('mycourses/update_content') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#contentEditModal').modal('hide');
                        $('#editcontentform')[0].reset();
                        get_topic_content(id);
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
    var id=$('#topic_id2').val();
    if($("#adddocumentform").parsley()) {
        if ($("#adddocumentform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#adddocumentform")[0]);
            console.log($("#adddocumentform").parsley().isValid());
            if($("#adddocumentform").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('mycourses/add_document') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
					$('#submitDoc').attr("disabled", true);
					},
                    success: function(response) 
                    {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#documentAddModal').modal('hide');
                        $('#adddocumentform')[0].reset();
                        get_topic_content(id);
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
    var id=$('#doc_topic_id').val();
    if ($("#editdocumentform").parsley()) {
        if ($("#editdocumentform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#editdocumentform")[0]);
            if ($("#editdocumentform").parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('mycourses/edit_document') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#documentEditModal').modal('hide');
                        $('#editdocumentform')[0].reset();
                        get_topic_content(id);
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

function saveMCQ() 
{
    var id = $('#topic_id5').val();
    if($("#addmcqform").parsley()) {
        if ($("#addmcqform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#addmcqform")[0]);
            if($("#addmcqform").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('add_mcq') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
					$('#submitmcq').html("Please Wait..").attr("disabled", true);
					},
                    success: function(response) {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#mcqAddModal').modal('hide');
                        $('#addmcqform')[0].reset();
                        get_topic_question(id);
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

function editMcq(id)
{
    var id = $('#edit_mcq'+id).data('id');
    var topic_id = $('#edit_mcq'+id).data('topic-id');
    var question = $('#edit_mcq'+id).data('question');
    var answer = $('#edit_mcq'+id).data('answer');
    var opt1 = $('#edit_mcq'+id).data('opt1');
    var opt2 = $('#edit_mcq'+id).data('opt2');
    var opt3 = $('#edit_mcq'+id).data('opt3');
    var opt4 = $('#edit_mcq'+id).data('opt4');
    var reason = $('#edit_mcq'+id).data('reason');
    var tags = $('#edit_mcq'+id).data('tags');
    var status = $('#edit_mcq'+id).data('is-active');
    $("#mcq_edit_id").val(id);
    $("#mcq_topic_id").val(topic_id);
    $("#ed_question").text(question);
    $("#ed_answer").val(answer);
    $("#ed_opt1").text(opt1);
    $("#ed_opt2").text(opt2);
    $("#ed_opt3").text(opt3);
    $("#ed_opt4").text(opt4);
    $("#ed_reason").text(reason);
    $("#ed_tags").text(tags);
    if(status == 1)
    {
        $("#ed_mcq_is_active").attr('checked', 'checked');
    }
    else
    {
        $("#ed_mcq_is_active").removeAttr('checked', 'checked');
    }
    $("#mcqEditModal").modal('show');
}

function updateMcq()
{
    var id=$('#mcq_topic_id').val();
    if ($("#editmcqform").parsley()) {
        if ($("#editmcqform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#editmcqform")[0]);
            if ($("#editmcqform").parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('mycourses/edit_mcq') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#mcqEditModal').modal('hide');
                        $('#editmcqform')[0].reset();
                        get_topic_question(id);
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

function saveTrueOrFalse() 
{
    var id = $('#topic_id4').val();
    if($("#addtofform").parsley()) {
        if ($("#addtofform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#addtofform")[0]);
            if($("#addtofform").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('add_true_or_false') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
					$('#submittfque').html("Please Wait..").attr("disabled", true);
					},
                    success: function(response) {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#tofAddModal').modal('hide');
                        $('#addtofform')[0].reset();
                        get_topic_question(id);
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

function editTrueOrFalse(id)
{
    var id = $('#edit_tof'+id).data('id');
    var topic_id = $('#edit_tof'+id).data('topic-id');
    var question = $('#edit_tof'+id).data('question');
    var answer = $('#edit_tof'+id).data('answer');
    var reason = $('#edit_tof'+id).data('reason');
    var tags = $('#edit_tof'+id).data('tags');
    var status = $('#edit_tof'+id).data('is-active');
    $("#tof_edit_id").val(id);
    $("#tof_topic_id").val(topic_id);
    $("#ed_tf_question").text(question);
    $("input[name=answer][value=" + answer + "]").prop('checked', true);
    $("#ed_tf_reason").text(reason);
    $("#ed_tf_tags").text(tags);
    if(status == 1)
    {
        $("#ed_tf_is_active").attr('checked', 'checked');
    }
    else
    {
        $("#ed_tf_is_active").removeAttr('checked', 'checked');
    }
    $("#tofEditModal").modal('show');
}

function updateTrueOrFalse() 
{
    var id=$('#tof_topic_id').val();
    if ($("#edittofform").parsley()) {
        if ($("#edittofform").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#edittofform")[0]);
            if ($("#edittofform").parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('mycourses/edit_true_or_false') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        new PNotify({
                            title: 'Success',
                            text:  response.msg,
                            type: 'success',
                            delay: 1000
                        });
                        $('#tofEditModal').modal('hide');
                        $('#edittofform')[0].reset();
                        get_topic_question(id);
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

// function mcqStatus(value)
// {
//     window.location.href = '/mcqStatus/' + value;
// }

// function tofStatus(value)
// {
//     window.location.href = '/tofStatus/' + value;
// }

function deleteDocument(id ,topic_id)
{
	Swal.fire({
  title: 'Are you sure?',
  text: "File permanently delete!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
	
  if (result.value) 
  {
        $.ajax({
            type: "POST",
            cache:false,
            async: false,
            url: "{{ route('delete_file') }}",
            data: { id:id , _token: '{{csrf_token()}}'},
           
            success: function(response) {
            	if(response.data =='success')
            	{
            		new PNotify({
	                    title: 'Success',
	                    text:  response.msg,
	                    type: 'success',
	                    delay: 1000
                	});
        	    console.log(topic_id);
                	get_topic_content(topic_id);

            	}
            	else
            	{
            		new PNotify({
	                    title: 'Error',
	                    text: response.msg,
	                    type: 'error',
	                    delay: 2000
                });
            	}

            }
        });
    
  }
});
}

</script>
@endsection