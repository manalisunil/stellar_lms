<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Home" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{asset('app-assets/assets/images/favicon.ico')}}">
         <link href="{{asset('app-assets/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
        <link href="{{asset('app-assets/plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
        <link href="{{asset('app-assets/plugins/nestable/jquery.nestable.min.css')}}" rel="stylesheet" />
        <link href="{{asset('app-assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('app-assets/plugins/animate/animate.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('app-assets/plugins/dropify/css/dropify.min.css')}}" rel="stylesheet">
        <link href="{{asset('app-assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet">
        <link href="{{asset('app-assets/plugins/jquery-steps/jquery.steps.css')}}">
        <link href="{{asset('app-assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('app-assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/jquery-ui.min.css')}}" rel="stylesheet">
        <link href="{{asset('app-assets/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/metisMenu.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('app-assets/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('app-assets/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/jquery-ui.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/assets/css/pnotify.custom.css')}}">
        <script type="text/javascript" src="{{asset('app-assets/assets/js/pnotify.custom.js')}}"></script>


    </head>
    <body data-layout="horizontal" style="background-color: #edf0f5;">
        
        <!-- Top Bar End -->
        <div class="page-wrapper1 " >
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
        <script src="{{asset('app-assets/assets/js/metismenu.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/waves.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/feather.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/js/jquery.slimscroll.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js')}}"></script>
        <script src="{{asset('app-assets/plugins/parsleyjs/parsley.min.js')}}"></script>
        <script src="{{asset('app-assets/assets/pages/jquery.validation.init.js')}}"></script>
        <!-- Required datatable js -->
        <script src="{{asset('app-assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{asset('app-assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/jszip.min.js')}}"></script>
        <script src="{{asset('app-assets/plugins/datatables/pdfmake.min.js')}}"></script>
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
        
    </body>
</html>

