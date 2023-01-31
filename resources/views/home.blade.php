@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid mt-4  mt-4 px-3 pe-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="cadrd cardd_top_orenge">
                <div class="modal-title pl-4">
                    <h5 class="" id="exampleModalLabel">Dashboard</h5>
                </div>
               <div class="card-body">                  
                   <div class="row px-3" style="">
                        @if(auth::user()->user_type_id !=3)
                        <div class="card shadow mx-1 p-0 " style="width:8%;border-radius: 14%!important;">
                            <div class="card-body">
                                <div class="row align-items-center gx-0">
                                    <div class="col">
                                        <!-- Title -->
                                        <h5 class="mb-1 d-flex justify-content-center">
                                            <b>Users</b>
                                        </h5>
                                        <!-- Heading -->
                                        <span class="h4 d-flex justify-content-center">
                                            <i class="fa-solid fa-user text-primary"></i>&nbsp;
                                            <span>{{$users}}</span>
                                        </span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mx-1 p-0 " style="width:8%;border-radius: 14%!important;">
                            <div class="card-body">
                                <div class="row align-items-center gx-0">
                                    <div class="col">
                                        <!-- Title -->
                                        <h5 class="mb-1 d-flex justify-content-center">
                                            <b>Companies</b>
                                        </h5>
                                        <!-- Heading -->
                                        <span class="h4 d-flex justify-content-center">
                                            <i class="fa-solid fa-building text-warning"></i>&nbsp;
                                            <span>{{$companies}}</span>
                                        </span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="card shadow mx-1 p-0 " style="width:8%;border-radius: 14%!important;">
                            <div class="card-body">
                                <div class="row align-items-center gx-0">
                                    <div class="col">
                                        <!-- Title -->
                                        <h5 class="mb-1 d-flex justify-content-center">
                                            <b>Courses</b>
                                        </h5>
                                        <!-- Heading -->
                                        <span class="h4 d-flex justify-content-center">
                                            <i class="fa-solid fa-book-open text-secondary"></i>&nbsp;
                                            <span>{{$cources}}</span>
                                        </span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mx-1 p-0 " style="width:8%;border-radius: 14%!important;">
                            <div class="card-body">
                                <div class="row align-items-center gx-0">
                                    <div class="col">
                                        <!-- Title -->
                                        <h5 class="mb-1 d-flex justify-content-center">
                                            <b>Subjects</b>
                                        </h5>
                                        <!-- Heading -->
                                        <span class="h4 d-flex justify-content-center">
                                            <i class="fa-solid fa-book text-success"></i>&nbsp;
                                            <span>{{$subjects}}</span>
                                        </span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mx-1 p-0 " style="width:8%;border-radius: 14%!important;">
                            <div class="card-body">
                                <div class="row align-items-center gx-0">
                                    <div class="col">
                                        <!-- Title -->
                                        <h5 class="mb-1 d-flex justify-content-center">
                                            <b>Chapters</b>
                                        </h5>
                                        <!-- Heading -->
                                        <span class="h4 d-flex justify-content-center">
                                            <i class="fa-solid fa-clone text-danger"></i>&nbsp;
                                            <span>{{$chapters}}</span>
                                        </span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mx-1 p-0 " style="width:8%;border-radius: 14%!important;">
                            <div class="card-body">
                                <div class="row align-items-center gx-0">
                                    <div class="col">
                                        <!-- Title -->
                                        <h5 class="mb-1 d-flex justify-content-center">
                                            <b>Topics</b>
                                        </h5>
                                        <!-- Heading -->
                                        <span class="h4 d-flex justify-content-center">
                                            <i class="fa-solid fa-tasks text-warning"></i>&nbsp;
                                            <span>{{$topics}}</span>
                                        </span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection