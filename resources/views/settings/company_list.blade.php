@extends('layouts.app')
@section('title', 'Company')
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
                                <th>Company Name</th>
                                <th>Email Id</th>
                                <th>Phone No</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $k=>$company)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{{$company->company_name}}</td>
                                <td>{{$company->email_id}}</td>
                                <td>{{$company->phone_no}}</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"  class="custom-control-input" id="customSwitch{{ $company->id }}"  value="{{ $company->id }}" onclick="companyStatus(this.value)" @if($company->is_active==1) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{ $company->id }}">@if($company->is_active==1) Active @else Inactive @endif</label>
                                    </div>
                                </td>
                                <td> 
                                    <button type="button" class="edit_icon edit_company ml-2 btn btn-sm"  data-id="{{ $company->id }}" onclick="editCompany({{ $company->id }})"><img class="menuicon tbl_editbtn" src="{{asset("app-assets/assets/images/edit.svg")}}" >&nbsp;</button>
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

<!-- The Add Company Modal -->
<div class="modal fade" id="addCompanyModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" name="addCompanyForm" id="addCompanyForm" role="form" enctype="multipart/form-data" autocomplete="off" data-parsley-validate data-parsley-trigger="keyup" data-parsley-trigger="focusout">
	            @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row ">
                        <div class="col-lg-1 pr-0">
                            <label for="unique-id-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Company Name<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="company_name" id="company_name" type="text" class="form-control" placeholder="Enter Company Name" required data-parsley-trigger="focusout" data-parsley-trigger="keyup" data-parsley-pattern="^[A-Za-z ][A-Za-z \.]*$"/>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="name-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Address<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <textarea name="address" id="address" type="text" class="form-control" placeholder="Enter Company Address" required></textarea>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="address-input" class="col-form-label">Phone No<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input required data-parsley-type="number" data-parsley-trigger="change" data-parsley-minlength="10" 
								data-parsley-maxlength="10" id="phone_no" name="phone_no" type="text" class="form-control" autocomplete="off" placeholder="Enter Phone Number" >                        
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-1 pr-0">
                            <label for="city-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;">Email Id<span class="text-danger"> * <span></label>
                        </div>
                        <div class="col-lg-3">
                            <input name="email_id" id="email_id" type="text" class="form-control" placeholder="Enter Email Id" required/>
                        </div>
                        <div class="col-lg-1 pr-0">
                            <label for="doc-input" class="col-form-label px-0 mx-0" style="width: 114%;text-align: left;"> Logo</label>
                        </div>
                        <div class="col-lg-3">
                            <input id="logo" name="logo" type="file" class="form-control" accept="image/*" data-parsley-trigger="keyup"  data-parsley-fileextension="jpg,png,svg,jpeg">
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
                    <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary" onclick="saveCompany();">
                </div>
	        </form>
        </div>
    </div>
</div>
<!-- End -->

<!-- The Edit Company Modal -->
<div class="modal fade" id="companyEditModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
	        <form method="post" name="updateCompanyForm" id="updateCompanyForm" role="form" enctype="multipart/form-data" autocomplete="off" data-parsley-validate>
	            @csrf
                <input  name="id" value="" id="id" type="hidden"  />
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>
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
    $(".odtabs").not("#tab1").addClass('btn-outline-secondary');
	$("#tab1").addClass('btn-secondary');

    var table = $('#datatable').DataTable({
        responsive: true,
        dom: 'l<"toolbar">frtip',
        initComplete: function(){
		    $("div.toolbar").html('<button id="addCompany" type="button" class="ml-2 btn btn-primary" data-toggle="modal" data-target="#addCompanyModal"><img class="menuicon" src="{{asset("app-assets/assets/images/add.svg")}}">&nbsp;Add Company</button><br />');
		}, 
        'columnDefs': [ {
            'targets': [5],
            'orderable': false,
        }]
    });
});

function saveCompany() 
{
    if ($("#addCompanyForm").parsley()) {
        if ($("#addCompanyForm").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#addCompanyForm")[0]);
            if ($("#addCompanyForm").parsley().isValid()) {
                $.ajax({
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ route('submit_company') }}",
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

function editCompany(companyId)
{
    $("#removeData").remove();
    $.ajax({
        url: "/edit_company/" + companyId,
        success: function(data) {
            $("#append_data").append(data.data);
            $('#companyEditModal').modal('show'); 
        }
    })
}

function courseUpdate()
{
    if ($("#updateCompanyForm").parsley()) {
        if ($("#updateCompanyForm").parsley().validate()) {
            event.preventDefault();
            var formData = new FormData($("#updateCompanyForm")[0]);
            if ($(updateCompanyForm).parsley().isValid()) {
                $.ajax({	
                    type: "POST",
                    cache:false,
                    async: false,
                    url: "{{ url('/update_company') }}",
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

function companyStatus(value)
{
    window.location.href = '/companyStatus/' + value;
}

</script>
@endsection