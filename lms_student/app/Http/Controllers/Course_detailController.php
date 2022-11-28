<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Course_detailController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('includes.course_detail');
    }
    public function topic_videos()
    {
        return view('includes.topic_videos');

    }
    public function topic_play_video()
    {
        return view('includes.topic_play_video');

    }
    public function quiz_test()
    {
    	return view('includes.test');
    }
}
