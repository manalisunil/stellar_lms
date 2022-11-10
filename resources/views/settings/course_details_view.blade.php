@extends('layouts.app')
@section('title', 'Course Details')
@section('content')
<div class="container-fluid mt-1">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body tabborder3">
                <div class="pl-2">
                    <h4 class="card-title">
                        <a href="{{ route('course_list') }}" style="text-decoration:none;">
                            <img class="mensuicon" src="{{asset('app-assets/assets/images/backs.png')}}" style="width:1.3rem;height:1.3rem;margin-right: 10px;">
                        </a>
                    {{$course->course_name}}&nbsp;[{{$course->course_id}}]</h4>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body tabborder">
                <div class="pl-2">
                    <h4 class="card-title">Course Description</h4>
                    <p class="card-text">{!! $course->course_description !!}</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body tabborder2">
                <div class="pl-2">
                    <h4 class="card-title">Course Deliverables</h4>
                    <p class="card-text">{!! $course->course_deliverables !!}</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body tabborder3">
                <div class="pl-2">
                    <h4 class="card-title">Course Eligibility</h4>
                    <p class="card-text">{!! $course->course_eligibility !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection