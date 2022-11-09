<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Home" name="description" />
        <meta content="" name="author" />
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{asset('app-assets/assets/images/favicon.ico')}}">
        <link href="{{asset('app-assets/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
        <link href="{{asset('app-assets/plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
        {{-- <link href="{{asset('app-assets/plugins/nestable/jquery.nestable.min.css')}}" rel="stylesheet" /> --}}
        <link href="{{asset('app-assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('app-assets/plugins/animate/animate.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('app-assets/plugins/dropify/css/dropify.min.css')}}" rel="stylesheet">
        {{-- <link href="{{asset('app-assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"> --}}
        {{-- <link href="{{asset('app-assets/plugins/jquery-steps/jquery.steps.css')}}"> --}}
        <link href="{{asset('app-assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('app-assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/font-awesome.all.min.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('app-assets/assets/css/jquery-ui.min.css')}}" rel="stylesheet">
        <link href="{{asset('app-assets/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        {{-- <link href="{{asset('app-assets/assets/css/metisMenu.min.css')}}" rel="stylesheet" type="text/css" /> --}}
        <link href="{{asset('app-assets/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('app-assets/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/jquery-ui.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/font-awesome.all.min.js')}}"></script>
        
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/assets/css/pnotify.custom.css')}}">
        <script type="text/javascript" src="{{asset('app-assets/assets/js/pnotify.custom.js')}}"></script>
        <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
        <!-- <script src="{{asset('app-assets/assets/js/ckeditor.js')}}"></script> -->
    </head>
    <body data-layout="horizontal" style="background-color: #edf0f5;">
        <div class="topbar">
            <div class="topbar-inner">
                <div class="topbar-left text-center text-lg-left">
                    <a href="{{route('home')}}" class="logo">
                        <span><img src="{{asset('app-assets/assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm" style="height: 25px;"></span>
                    </a>
                </div>
                <div class="navbar-custom-menu " style="    margin-left: 3.5rem !important">
                    <div id="navigation">
                        <ul class="navigation-menu">
                        <li class="{{ Request::is('home') ? 'submenuactive' : '' }}">
                                <a href="{{ route('home') }}">
                                    <i class="dripicons-basketball {{ Request::is('home') ? 'submenuactivei' : '' }}"></i>
                                    Dashboard
                                </a>
                        </li>
                      
                        <li class="{{ Request::is('settings/*') ? 'submenuactive' : '' }}">
                                <a href="{{ route('user') }}">
                                    <i class="dripicons-basket {{ Request::is('settings/*') ? 'submenuactivei' : '' }}"></i>
                                    Settings
                                </a>
                        </li>
                       
                     
                        
                        </ul>
                    </div>
                </div>
                <!-- Navbar -->
                <nav class="navbar-custom float-right">
                    <ul class="list-unstyled topbar-nav mb-0">
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <img src="{{asset('app-assets/assets/images/users/user-1.png')}}" alt="profile-user" class="rounded-circle" />
                                <span class="ml-1 nav-user-name hidden-sm">
                                  
                                  
                                        {{Auth::user()->first_name}}  {{Auth::user()->last_name}}
                                    
                                <i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                
                                <a class="dropdown-item" href="{{ route('logout') }}"><i class="ti-power-off text-muted mr-2"></i> Logout</a>
                                   
                                <a class="dropdown-item" href=""><i class="fa fa-user ti-power-off text-muted mr-2"></i> Profile</a>
                            </div>
                        </li>
                        <li class="menu-item">
                            <a class="navbar-toggle nav-link" id="mobileToggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Top Bar End -->
        <div class="page-wrapper">
            <div class="page-content">
                @yield('content')
                <footer class="footer text-center text-sm-left">
                    <div class="boxed-footer">
                        &copy; 2022 <span class="text-muted d-none d-sm-inline-block float-right"> Stellar Innovations Pvt Ltd </span>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{asset('app-assets/assets/js/bootstrap.bundle.min.js')}}"></script>
        {{-- <script src="{{asset('app-assets/assets/js/metismenu.min.js')}}"></script> --}}
        <script src="{{asset('app-assets/assets/js/waves.js')}}"></script>
        {{-- <script src="{{asset('app-assets/assets/js/feather.min.js')}}"></script> --}}
        <script src="{{asset('app-assets/assets/js/jquery.slimscroll.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js')}}"></script>
        {{-- <script src="{{asset('app-assets/plugins/parsleyjs/parsley.min.js')}}"></script> --}}
        <script src="{{asset('app-assets/assets/pages/jquery.validation.init.js')}}"></script>
        <!-- Required datatable js -->
        <script src="{{asset('app-assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{asset('app-assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/jszip.min.js')}}"></script>
        {{-- <script src="{{asset('app-assets/plugins/datatables/pdfmake.min.js')}}"></script> --}}
        <script src="{{asset('app-assets/plugins/datatables/vfs_fonts.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/buttons.html5.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/buttons.print.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
        <!-- Responsive examples -->
        <script src="{{asset('app-assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/pages/jquery.datatable.init.js')}}"></script>
        <script src="{{asset('app-assets/plugins/dropify/js/dropify.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/pages/jquery.form-upload.init.js')}}"></script>
        <script src="{{asset('app-assets/assets/pages/jquery.animate.init.js')}}"></script>
        <!-- App js -->
        <script src="{{asset('app-assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/pages/jquery.sweet-alert.init.js')}}"></script>
        <script src="{{asset('app-assets/plugins/jquery-steps/jquery.steps.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/pages/jquery.form-wizard.init.js')}}"></script>
        <script src="{{asset('app-assets/plugins/repeater/jquery.repeater.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/pages/jquery.form-repeater.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('app-assets/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('app-assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{asset('app-assets/plugins/select2/select2.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/timepicker/bootstrap-material-datetimepicker.js')}}"></script>
        <script src="{{asset('app-assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/pages/jquery.forms-advanced.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/app.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/parsley.min.js')}}"></script>
        <script>
        $('.multipleselect').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true
        });
        
        </script>
    </body>
</html>