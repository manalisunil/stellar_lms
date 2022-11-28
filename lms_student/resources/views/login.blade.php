<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Login</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet"> -->
        <!-- Template Main CSS File -->
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <div class="content">
                <div class="container">
                    <div class="row ">
                        <div class="col-md-6">
                            <img src="{{ asset('assets/img/undraw_remotely_2j6y.svg')}}" alt="Image" class="img-fluid">
                        </div>
                        <div class="col-md-6 contents">
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-8">
                                    
                                    <div class="card mt-5 min-vh-70 py-4">
                                        <div class="pt-4 pb-2">
                                            <h5 class="card-title text-center pb-0">Login</h5>
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
                                                            <p class="small mb-0"> <a class="btn btn-link" href="{{ route('password.request') }}">
                                                                {{ __('Forgot Your Password?') }}
                                                            </a></p>
                                                        @endif
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100" type="submit">Login</button>
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
            </div>
            <!-- Section: Design Block -->
            </main><!-- End #main -->
            <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
            <!-- Vendor JS Files -->
            <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
           
        </body>
    </html>