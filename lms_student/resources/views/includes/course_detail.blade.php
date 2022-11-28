@extends('layouts.app')

@section('content')
  <!-- ======= Header ======= -->
 @include('includes.header')
<!-- End Sidebar-->
  <!-- End Sidebar-->
<!-- <script src="{{ asset('assets/vendor/scrollable-tabs/move.min.js')}}"></script> -->
  <!-- <link href="{{ asset('assets/vendor/scrollable-tabs/scrollable-tabs.css')}}" rel="stylesheet" /> -->
<style type="text/css">
    /* Style the tab */
.tab-navigation {
  /*border: 1px solid #ccc;
  background-color: #f1f1f1;*/
}

.ch_tab {
  overflow-x: hidden;
  white-space: nowrap;
  margin-left: 30px;
  margin-right: 30px;
}


.ch_tab div,
.tab-control {
  background-color: inherit;
  display: inline-block;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 2px 16px;
  transition: 0.3s;
  font-size: 15px;
}



/* Create an active/current tablink class */
.chapter_list.active {
  background-color: #fff;
  color: #66C835;
  border-top: 2px solid #66C835;
  font-weight: bold;
}


.arrow-left {
  float: left;
}

.arrow-right {
  float: right;
</style>


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
                <div class="card-footer p-0">
                 
   <div class="tab-navigation">
          <span class="tab-control arrow-left" onclick="moveNavigation(-90)">
            <img class="" src="{{ asset('assets/img/left-arrow-circle-solid.png')}}">
          </span>
          <span class="tab-control arrow-right" onclick="moveNavigation(90)">
            <img class="" src="{{ asset('assets/img/right-arrow-circle-solid-24.png')}}">
          </span>

  <div class="ch_tab">

     <div class="chapter_list tablinks active" onclick="return openCity(event,'London')"><i class='bx bxs-home-circle'></i></div>
    <div class="chapter_list tablinks" onclick="return openCity(event, 'Paris')">Ch 1</div>
    <div class="chapter_list tablinks" onclick="return openCity(event, 'Tokyo')">Ch 2</div>
    <div class="chapter_list tablinks" onclick="return openCity(event,'London')">Ch 3</div>
    <div class="chapter_list tablinks" onclick="return openCity(event, 'Tokyo')">Ch 4</div>
    <div class="chapter_list tablinks" onclick="return openCity(event, 'Paris')">Ch 5</div>
    <div class="chapter_list tablinks" onclick="return openCity(event,'London')">Ch 6</div>

  </div>
</div>
<div id="London" class="tabcontent d-none">
  <h3>Januaray</h3>
  <p>London is the capital city of England.</p>
</div>

<div id="Paris" class="tabcontent d-none">
  <h3>Febrary</h3>
  <p>Paris is the capital of France.</p>
</div>

<div id="Tokyo" class="tabcontent d-none">
  <h3>March</h3>
  <p>Tokyo is the capital of Japan.</p>
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
                <div class="col-md-10"><h4 class="card-title">Microbiology > Topics</h4> </div>
                <div class="col-md-2">
                    <button onclick="listView()" id="list_btn" class="btn btn-primary btn-sm fs-5"><i class='bx bx-list-ul' ></i></button>
                    <button onclick="gridView()" id="grid_btn" class="btn  btn-sm fs-5"><i class='bx bx-grid-alt'></i></button> </div>
            </div>
            <div class="container grid-container d-none">
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                      <div class="card">
                        
                        <div class="card-body">
                            <div class=" topic-head col-xl-4 col-lg-4 col-md-4 col-sm-3 col-xs-1 offset-4">
                                <p class="topic-title">T1</p></div>
                                <div class="row">
                                <p class="topic_name">Microbiology - 1</p>
                                <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                            <div class="col-12 text-center mt-1 ">
                                <a href="{{route('topic_videos')}}"> <img src="{{ asset('assets/img/icons8-youtube-48.png')}}" height="30"></a>
                               <span onclick="open_model()"><img src="{{ asset('assets/img/icons8-content-65.png')}}" height="30" ></span>
                                <img src="{{ asset('assets/img/icons8-time-card-48.png')}}" height="30">
                            </div>
                        </div>

                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                      <div class="card">
                        
                        <div class="card-body">
                            <div class=" topic-head col-xl-4 col-lg-4 col-md-4 col-sm-3 col-xs-1 offset-4">
                                <p class="topic-title">T1</p></div>
                               <div class="row">
                                <p class="topic_name">Microbiology - 1</p>
                                <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                            <div class="col-12 text-center mt-1 ">
                                <a href="{{route('topic_videos')}}"> <img src="{{ asset('assets/img/icons8-youtube-48.png')}}" height="30"></a>
                               <span onclick="open_model()"><img src="{{ asset('assets/img/icons8-content-65.png')}}" height="30" ></span>
                                <img src="{{ asset('assets/img/icons8-time-card-48.png')}}" height="30">
                            </div>
                        </div>
                        
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                      <div class="card">
                        
                        <div class="card-body">
                            <div class=" topic-head col-xl-4 col-lg-4 col-md-4 col-sm-3 col-xs-1 offset-4">
                                <p class="topic-title">T1</p>
                            </div>
                            <div class="row">
                                <p class="topic_name">Microbiology - 1</p>
                                <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                            <div class="col-12 text-center mt-1 ">
                                <a href="{{route('topic_videos')}}"><img src="{{ asset('assets/img/icons8-youtube-48.png')}}" height="30"></a>
                                <span onclick="open_model()"><img src="{{ asset('assets/img/icons8-content-65.png')}}" height="30" ></span>
                               <img src="{{ asset('assets/img/icons8-time-card-48.png')}}" height="30">
                            </div>
                        </div>
                        
                      </div>
                    </div>
                </div>
            </div>
            <div class="container list-container">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card"> 
                <div class="card-body row p-0">
                    <div class="topic-head-list col-sm-2 col-md-2 col-lg-1 align-middle">
                        <p class="topic-title mt-2 fs-5">T1</p>
                    </div>
                    <div class="col-sm-10 col-md-10 col-lg-11  ">
                        <div class="row">
                            <div class="col-10">
                                <p class="card-text  p-3"> <span class="topic_name align-middle">Microbiology - 1</span>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                            <div class="col-2 mt-3 ">
                               <a href="{{route('topic_videos')}}"> <img src="{{ asset('assets/img/icons8-youtube-48.png')}}" height="30"></a>
                                <span onclick="open_model()"><img src="{{ asset('assets/img/icons8-content-65.png')}}" height="30" ></span>
                                <img src="{{ asset('assets/img/icons8-time-card-48.png')}}" height="30">
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
     </div>
 </main>
  <div class="modal fade" id="test_model" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header p-2">
          <span class="fs-6 me-auto text-primary fw-bold">Introduction to Microbiology</span>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
              
                   
                <div class="card-body-head">
                    <p class="fw-bold font-dark pt-1">Welcome to the MCQ practice session ! Here you will find multiple choice questions per sub-topic, per chapter</p>
                      <div class="col-12">
                          <i class='bx bxs-check-circle' style='color:#66c835' ></i>
                          Gain complete understanding of topics by providing answer explanation for correct and incorrect choices
                        </div>
                         <div class="col-12">
                          <i class='bx bxs-check-circle' style='color:#66c835' ></i>
                          Self-analyze performance based on instant progress report that provides accuracy and number of attempted questions
                      </div>
                         <div class="col-12">
                      
                         <i class='bx bxs-check-circle' style='color:#66c835' ></i>
                          Make notes for future reference
                      </div>
                       
                </div>
                
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-danger mr-auto">Start Test</button>
        </div>
      </div>
    </div>
  </div>

<!-- <script src="{{ asset('assets/vendor/scrollable-tabs/scrollable-tabs.js')}}"></script> -->
@endsection
@section('script')

<script type="text/javascript">
    function open_model()
    {
        $("#test_model").modal('show');
    }
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
    return false;
}

function moveNavigation(byX) {
  var navigation= document.getElementsByClassName("ch_tab")[0];
  navigation.scrollLeft= navigation.scrollLeft + byX;
} 


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