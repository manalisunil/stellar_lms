@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-6  min-vh-70">
            <div class="mt-5 min-vh-70 py-4">
            <img src="{{ asset('assets/img/login_img.svg')}}" alt="Image" class="img-fluid">
        </div>
        </div>
        <div class="col-md-6 contents ">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-8 col-mg-p-4">
                    
                    <div class="login_card card  min-vh-70 py-4" >
                        <div class="pt-3 pb-3">
                            <h5 class="card-title text-center pb-0 fw-bold">Login</h5>
                            <!-- <p class="text-center small">Enter your username & password to login</p> -->
                        </div>
                        <div class="card-body ">
                            <form action="#" method="post" class="row g-3 login_page">
                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Email ID</label>
                                     <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                                
                                <div class="g-3 row">
                                    <div class="col-6">
                                        <div class="form-check">
                                             <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        @if (Route::has('password.request'))
                                            <p class="small mb-0 float-end"> <a  href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a></p>
                                        @endif
                                       
                                    </div>
                                </div>
                                <div class="col-12 mt-0">
                                    <button class="btn btn-primary w-100 fw-bold" type="submit">Login</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0">Don't have an account? <a href="pages-register.html"> Sign Up!</a></p>
                                </div>
                                
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
@endsection
