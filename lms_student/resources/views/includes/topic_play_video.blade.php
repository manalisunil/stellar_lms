@extends('layouts.app')
@section('content')
<!-- ======= Header ======= -->
@include('includes.header')
<!-- End Sidebar-->
<!-- End Sidebar-->
<main id="main" class="main">
    <div class="container">
         <div class="col-12 col-md-12 col-lg-12">
          <div class="card"> 
            <div class="card-body row p-0">
                <div class="col-sm-12 col-md-12 col-lg-12 align-middle py-1">
                    <span class="fs-6"><img src="{{ asset('assets/img/left-arrow-circle-solid-24.png')}}">
                        <strong class="me-auto text-primary">Introduction to Microbiology</strong></span>
                        <span class="float-end "><button type="button" class="mcq-btn btn btn-success btn-sm">Click Here For MCQ</button></span>
                </div>
               
            </div>  
          </div>
        </div>
           
        <div class="col-12">
           
            <div class="container list-container row shadow p-2 ">
                <iframe width="420" height="450vh" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                </iframe>
               
            </div>
           
            
        </div>
    </div>

</main>
<!--Container Main end-->
<!-- </aside> -->
<!-- End Sidebar-->
@endsection
@section('script')
<script type="text/javascript">

</script>
@endsection