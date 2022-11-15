@extends('layouts.app')
@section('title', 'Chapter')
@section('content')
<style type="text/css">
   .nav-link[data-toggle].collapsed:before {
     content: '▶';
     font-size: 14px;
    /*color: #777;*/
  /*float: right;*/
   margin-left: 5px;
  
    
}
.nav-link[data-toggle]:not(.collapsed):before {
     content: "▼";
      font-size: 14px;
      /*color: #777;*/
      margin-left: 5px;
}
.side_menu
{
   font-size: 17px
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
                       <a class="nav-link  collapsed " href="#submenu1" data-toggle="collapse" data-target="#submenu{{$s1}}"><!-- <i class="fa fa-table"></i> --> <span class="font-weight-bold d-sm-inline side_menu">   {{$subjects->getSubject['subject_name']}}</span></a>
                       <div class="collapse" id="submenu{{$s1}}" aria-expanded="false">
                           <ul class="flex-column pl-2 nav">
                               <!-- <li class="nav-item"><a class="nav-link py-0" href="#"><span>Course1</span></a></li> -->
                               @php $all_chapters = $chapters->where('subject_id',$subjects->subject_id); @endphp
                                   @if(count($all_chapters) > 0)
                                     @foreach($all_chapters as $ch=>$chpter)
                                        <li class="nav-item">
                                            <a class="nav-link  collapsed py-1 pl-4" href="#submenu1sub1" data-toggle="collapse" data-target="#submenu1sub{{$ch}}"><span class=""><!-- <i class="fa-regular fa-folder pr-1"></i> --> {{$chpter->chapter_name}}</span></a>
                                            <div class="collapse" id="submenu1sub{{$ch}}" aria-expanded="false">
                                                <ul class="flex-column nav pl-4">
                                                   @php $all_topics = $topic->where('chapter_id',$chpter->id);
                                                   @endphp
                                                   @if(count($all_topics) > 0)
                                                   @foreach($all_topics as $topc)
                                                    <li class="nav-item">
                                                        <a class="nav-link p-1  pl-4 " href="#"><i class="fa-solid fa-file-lines pr-1"></i>
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
        <div class="col pt-2">
            <button>Add Video Link</button>
            <button>Add Document</button>
            <button>Add Content</button>
            
        </div>
    </div>
         </div>
      </div>
   </div>
</div>


<script type="text/javascript">

</script>
@endsection