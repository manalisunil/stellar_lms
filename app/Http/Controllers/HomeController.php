<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\User;
use App\Models\Company;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('is_active',1)->count();
        $companies = Company::where('is_active',1)->count();
        $cources = Course::where('is_active',1)->count();
        $subjects = Subject::where('is_active',1)->count();
        $chapters = Chapter::where('is_active',1)->count();
        $topics = Topic::where('is_active',1)->count();
        return view('home',compact('users','companies','cources','subjects','chapters','topics'));
    }
}
