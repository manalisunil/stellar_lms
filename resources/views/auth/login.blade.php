@extends('layouts.app1')
@section('title', 'Login')
@section('content')
<body class="account-body">
    <div class="container">
        <div class="row vh-100">
            <div class="col-12 align-self-center">
                <div class="auth-page">
                    <div class="card auth-card shadow-lg">
                        <div class="card-body p-0">
                            <div class="text-center" style="color:red;width:100%">
                                @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-danger"> {{$error}} </div>
                                @endforeach
                                @endif
                            </div>
                            @if(Session::has('success'))
                            <div class="alert alert-success text-center">
                                {{Session::get('success')}}
                            </div>
                            @endif
                            @if(Session::has('error'))
                            <div class="alert alert-danger text-center">
                                {{Session::get('error')}}
                            </div>
                            @endif
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                Password Changed Successfully !
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-6">
                                    <img src="{{asset('app-assets/assets/images/userlogin.png')}}" width="100%" style="height:435px!important;">
                                </div>
                                <div class="col-lg-6" style="align-self:center !important; width:50%;">
                                    
                                    <div class="col-lg-10 text-center ">
                                        <a class="logo logo-admin"><img src="{{asset('app-assets/assets/images/logo-sm.png')}}" width="60%" height="auto" alt="logo"></a>
                                        
                                    </div>
                                    <div class="col-lg-10  pt-4  text-center"> <b><h5> Welcome to Stellar - Learning Management System </b> </h5></div>
                                    <form class="form-horizontal auth-form " method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="">
                                            <div class="col-lg-2 ">
                                                <label><strong>Email ID</strong></label>
                                            </div>
                                            <div class="col-lg-10 ">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class=" mt-2">
                                            <div class="col-lg-2">
                                                <label for="password"><strong>Password</strong></label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2 ml-1">
                                            <div class="col-lg-4 pt-2 float-right" style="font-size:14px !important">
                                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                            </div>
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-6">
                                                @if (Route::has('password.request'))
                                                <a class="btn  " href="{{ route('password.request') }}" style="    font-size: 14px !important; font-weight: bold;">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mt-2">
                                                <button  class="btn col-md-10 text-center btn-primary loginbtn" type="submit">LOGIN</button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div><!--end container-->
    
</body>
@endsection