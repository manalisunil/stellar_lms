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
                                            <img src="{{asset('app-assets/assets/images/abstractor.png')}}" width="100%" style="height:435px!important;">
                                        </div>
                                        <div class="col-lg-6" style="align-self:center !important; width:50%;">
                                              <div class="col-lg-10 text-center">
                                                
                                               
                                            <a class="logo logo-admin"><img src="{{asset('app-assets/assets/images/logo-sm.png')}}" width="60%" height="auto" alt="logo"></a>
                                                
                                            </div>
                                             <div class="col-lg-10 pt-4  text-center "> <b><h5> Welcome to Stellar - Abstractor Vendor Management System </b> </h5>
                                             </div>
                                            <form class="form-horizontal auth-form my-4" method="POST" action="{{ route('password.update') }}">
                                                @csrf
                                                 <input type="hidden" name="token" value="{{ $token }}">
                                                <div class="">                                                  
                                                    <div class="col-lg-3 ">
                                                        <label><strong>Email</strong></label>
                                                    </div>
                                                    <div class="col-lg-10 ">
                                                           <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$email}}"  autocomplete="email"   readonly>

                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                 <div class=">">
                                                    <div class="col-lg-3 ">
                                                        <label for="password"><strong>Password</strong></label>
                                                    </div>
                                                    <div class="col-lg-10 ">
                                                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" autofocus>
                                                   

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                 <div class=">">
                                                    <div class="col-lg-3 ">
                                                        <label for="password"><strong>Confirm Password</strong></label>
                                                    </div>
                                                    <div class="col-lg-10 ">
                                                       <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                                                    @error('password_confirmation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                               <div class=" row justify-content-end col-lg-10">
                                                     
                                                @if (Route::has('login'))
                                                            <a class="btn p-0 " href="{{ route('login') }}" style="    font-size: 14px !important; font-weight: bold;">
                                                               {{ __('Back to Login') }}
                                                            </a>
                                                        @endif
                                            </div>
                                                <div class="row">
                                                    <div class="col-lg-12 mt-2">
                                                        <button  class="btn col-md-10 text-center btn-primary loginbtn" type="submit">{{ __('Send Password Reset Link') }} </button>
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
