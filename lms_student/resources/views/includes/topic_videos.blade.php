@extends('layouts.app')
@section('content')
<!-- ======= Header ======= -->
@include('includes.header')
<!-- End Sidebar-->
<!-- End Sidebar-->
<main id="main" class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title text-secondary"><span class="title-icon me-2"><img class="" src="{{ asset('assets/img/icon1.svg')}}"></span>Microbiology</div>
                    </div>
                    
                    <div class="card-body-head">
                        A microorganism is defined as a living thing that is so small it must be viewed with a microscope. Some microorganisms like viruses are so small they can only be seen with special electron microscopes
                    </div>
                    <div class="card-footer border-top-1">
                        
                        <div class="items">
                            <div class="chapter_list" ><a href="#" ><i class="bi bi-house"></i>Home</a></div>
                            <div class="chapter_list"><a href="#" >Chapter 1</a></div>
                            <div class="chapter_list"><a href="#" >Chapter 2</a></div>
                            <div class="chapter_list"><a href="#" >Chapter 3</a></div>
                            <div class="chapter_list"><a href="#" >Chapter 4</a></div>
                            <div class="chapter_list"><a href="#" >Chapter 5</a></div>
                            <div class="chapter_list"><a href="#" >Chapter 6</a></div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="row"> -->
                        <!-- <div class="col-8"> -->
                        <div id="donutChart"></div>
                        <!-- </div> -->
                        <!-- <div class="col-2"> -->
                        <!-- </div> -->
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-12">
             <div class="row mb-3 mt-0">
                <div class="col-md-12"><h4 class="card-title">Microbiology > Introduction to Microbiology</h4> </div>
                
            </div>
            <div class="container list-container row shadow p-2">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="index.html"><i class="bi bi-house-door"></i></a></li>
                              <li class="breadcrumb-item"><a href="#">Select Videos</a></li>
                              <li class="breadcrumb-item active">6</li>
                            </ol>
                        </nav>
                    </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <img src="{{ asset('assets/img/thumbnail.jpg')}}" class="card-img-top" alt="...">
                        <div class="card-body p-1 align-middle">
                           
                            <p class="text-secondary fw-bold mb-1">Introduction to Microbiology - 05:10</p>
                        </div>
                        <div class="card-footer p-1">
                            <img src="assets/img/Profile-img.jpg" alt="Profile" class="videos_img rounded-circle">
                           <span class=" fw-bold text-dark">John Smith</span> <small class="text-muted ">- 1 Month ago</small><span class="fw-bold text-dark float-end "><i class="bi bi-eye text-primary fw-bold "></i>&nbsp;20 Views </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <img src="{{ asset('assets/img/thumbnail.jpg')}}" class="card-img-top" alt="...">
                        <div class="card-body p-1 align-middle">
                           
                            <p class="text-secondary fw-bold mb-1">Introduction to Microbiology - 05:10</p>
                        </div>
                        <div class="card-footer p-1">
                            <img src="assets/img/Profile-img.jpg" alt="Profile" class="videos_img rounded-circle">
                           <span class=" fw-bold text-dark">John Smith</span> <small class="text-muted ">- 1 Month ago</small><span class="fw-bold text-dark float-end "><i class="bi bi-eye text-primary fw-bold "></i>&nbsp;20 Views </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <img src="{{ asset('assets/img/thumbnail.jpg')}}" class="card-img-top" alt="...">
                        <div class="card-body p-1 align-middle">
                           
                            <p class="text-secondary fw-bold mb-1">Introduction to Microbiology - 05:10</p>
                        </div>
                        <div class="card-footer p-1">
                            <img src="assets/img/Profile-img.jpg" alt="Profile" class="videos_img rounded-circle">
                           <span class=" fw-bold text-dark">John Smith</span> <small class="text-muted ">- 1 Month ago</small><span class="fw-bold text-dark float-end "><i class="bi bi-eye text-primary fw-bold "></i>&nbsp;20 Views </span>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
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
$(document).ready(function(){

$('.items').slick({
dots:false,
adaptiveHeight: true,
infinite: false,
// centerMode:false,
// centerPadding: '10px',
// draggable: false,
accessibility: true,
focusOnSelect:true,
slidesToShow: 3,
slidesToScroll:1,
// variableWidth: true,
//  prevArrow:"<button type='button' class='slick-prev pull-left'><i class='bi bi-arrow-bar-left' aria-hidden='true'></i></button>",
// nextArrow:"<button type='button' class='slick-next pull-right'><i class='bi bi-arrow-bar-right' aria-hidden='true'></i></button>",
responsive: [
{
breakpoint: 1024,
settings: {
slidesToShow: 3,
slidesToScroll: 3,
infinite: true,
dots: true
}
},
{
breakpoint: 600,
settings: {
slidesToShow: 2,
slidesToScroll: 2
}
},
{
breakpoint: 480,
settings: {
slidesToShow: 1,
slidesToScroll: 1
}
}
// You can unslick at a given breakpoint now by adding:
// settings: "unslick"
// instead of a settings object
]
});
});
document.addEventListener("DOMContentLoaded", () => {
new ApexCharts(document.querySelector("#donutChart"), {
series: [60, 30, 10],
chart: {
height: 180,
type: 'donut',
toolbar: {
show: false
}
},
labels: ['Correct Answer 60%', 'Wrong Answer 30%', 'Unanswered 10%'],
}).render();
});
function gridView()
{
$(".grid-container").removeClass('d-none');
$(".list-container").addClass('d-none');
$("#grid_btn").addClass('btn-primary');
$("#list_btn").removeClass('btn-primary');
}
function listView()
{
$(".grid-container").addClass('d-none');
$(".list-container").removeClass('d-none');
$("#grid_btn").removeClass('btn-primary');
$("#list_btn").addClass('btn-primary');
}
</script>
@endsection