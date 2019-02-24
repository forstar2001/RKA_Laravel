<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>RKA - Relentless Kinetics Anywhere</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ url('/') }}/public/admin_asset/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    

        <!-- FontAwesome 4.3.0 -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons 2.0.0 -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    

        <!-- Theme style -->
        <link href="{{ url('/') }}/public/admin_asset/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="{{ url('/') }}/public/admin_asset/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="{{ url('/') }}/public/admin_asset/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="{{ url('/') }}/public/admin_asset/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

        <!-- Select2 -->
        <link rel="stylesheet" href="{{ url('/') }}/public/admin_asset/plugins/select2/dist/css/select2.min.css">
        <!---Datatable CSS -->
        <link rel="stylesheet" href="{{ url('/') }}/public/admin_asset/plugins/datatables/dataTables.bootstrap.css" />
        
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{ url('/') }}/public/admin_asset/plugins/jQuery/jQuery-2.1.3.min.js" type="text/javascript"></script>

        <!-- jQuery UI -->
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>

        <!-- Bootstrap -->
        <script src="{{ url('/') }}/public/admin_asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
 
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="{{ url('/') }}/admin_asset/dist/js/pages/dashboard.js" type="text/javascript"></script>-->
        <script src="{{ url('/') }}/public/admin_asset/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="{{ url('/') }}/public/admin_asset/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
 
        <script src="{{ url('/') }}/public/admin_asset/plugins/slimScroll/jquery.slimscroll.min.js"></script>

        <!-- App -->
        <script src="{{ url('/') }}/public/admin_asset/dist/js/app.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- Select2 -->
        <script src="{{ url('/') }}/public/admin_asset/plugins/select2/dist/js/select2.full.min.js"></script>
        
        <!-- Datatable JS -->
        <script src="{{ url('/') }}/public/admin_asset/plugins/datatables/jquery.dataTables.js"></script>
        <script src="{{ url('/') }}/public/admin_asset/plugins/datatables/dataTables.bootstrap.js"></script>

        <script>
            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2()
            });

        </script>
    </head>

    <body class="skin-blue">
        <div class="wrapper">

            <header class="main-header">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Logo -->
                <a href="{{ route('Admin') }}" class="logo">
                <img src="{{ url('/') }}/public/default/images/logo/Black.svg" alt="" title="">
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="welcome-user hidden-xs"><a href="#">Welcome&nbsp;&nbsp;Admin! <b><?php echo session('user_type'); ?></b></a></li>
                            <li class="dropdown user user-menu">
                                <a href="{{ route('Adminlogout') }}">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> <span class="hidden-xs">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    @if(session('profile_picture') != "" && file_exists("uploads/profile_picture/".session('profile_picture')))
                    <div class="business-logo">
                        <img src="{{ url('/') }}/uploads/profile_picture/{{ session('profile_picture') }}" alt="" />
                    </div>
                    @endif
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="<?php echo(isset($menu) && $menu=='user_list')?'active':''; ?>"><a href="{{ route('Admin') }}"> Manage Users</a></li>
                        <li class="<?php echo(isset($menu) && $menu=='group_workout')?'active':''; ?>"><a href="{{ route('GroupWorkoutInfo') }}"> Manage Group Work-Out Info and Location</a></li>
                        <li class="<?php echo(isset($menu) && $menu=='gym_membership')?'active':''; ?>"><a href="{{ route('GymMembership') }}"> Manage Gym Membership</a></li>
                        <li class="<?php echo(isset($menu) && $menu=='outdoor_workout')?'active':''; ?>"><a href="{{ route('OutdoorWorkoutInfo') }}"> Manage Outdoor Work-Out Locations</a></li>
                        <li class="<?php echo(isset($menu) && $menu=='scheduled_race')?'active':''; ?>"><a href="{{ route('ScheduledRacesInfo') }}"> Manage Scheduled Races</a></li>
                        <li class="<?php echo(isset($menu) && $menu=='manage_paypal')?'active':''; ?>"><a href="{{ route('PayPalInfo') }}"> Manage PayPal</a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('content_header')
                </section>

                <section class="content">
                @yield('content')
          <!-- Small boxes (Stat box) -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b></b>
                </div>
                Copyright &copy; 2018. All rights reserved.
            </footer>
        </div><!-- ./wrapper -->
    </body>


</html>