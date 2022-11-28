@extends('layouts.app')
@section('content')
<!-- ======= Header ======= -->
@include('includes.header')
<!-- End Sidebar-->
<!-- End Sidebar-->
<style type="text/css">
    .slick-slide
    {
        width: 2%;
    }
</style>
<main id="main" class="main">
    <div class="container">
         <div class="col-12 col-md-12 col-lg-12">
          <div class="card"> 
            <div class="card-body row p-0">
                <div class="col-sm-12 col-md-12 col-lg-12 align-middle py-1">
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
        </div>
           
        <div class="col-12">
           
            <div class="container list-container row shadow p-2 ">
               
               
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
</script>
@endsection