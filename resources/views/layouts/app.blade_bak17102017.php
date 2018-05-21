<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="images/primex/primex-icon.png" type="image/png">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Dashboard - PrimeX Management</title>

  <!--icheck-->
  <link type="text/css" href="js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link type="text/css" href="js/iCheck/skins/square/square.css" rel="stylesheet">
  <link type="text/css" href="js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="js/iCheck/skins/square/blue.css" rel="stylesheet">

  <!--dashboard calendar-->
  <link type="text/css" href="css/clndr.css" rel="stylesheet">


  <!--common-->
  <link type="text/css" href="css/style.css" rel="stylesheet">
  <link type="text/css" href="css/style-responsive.css" rel="stylesheet">


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="index.html"><img src="images/primex/primexlogo.png" alt="PrimeX Auto Detailing" class="img-responsive"></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="images/primex/primex-icon.png" alt="PrimeX Auto Detailing" class="img-responsive"></a>
        </div>
        <!--logo and iconic logo end-->
        <input id="baseURL" type="hidden" value="{{ url('/') }}">
        <div class="left-side-inner">
 

            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="menu-list {{Request::is('service-pending')|Request::is('service-completed') ? 'nav-active' : '' }}"><a href="#"><i class="fa fa-clock-o"></i> <span>Service Queue</span></a>
                    <ul class="sub-menu-list">
                        <li class="{{Request::is('service-pending') ? 'active' : '' }}"><a href="{{url('service-pending')}}"> Pending</a></li>
                        <li class="{{Request::is('service-completed') ? 'active' : '' }}"><a href="{{url('service-completed')}}"> Completed</a></li>
                    </ul>
                </li>
 

                <li class="{{Request::is('member') ? 'active' : '' }}"><a href="{{url('member')}}"><i class="fa fa-users"></i> <span>Members</span></a></li>

                <li class="menu-list"><a href=""><i class="fa fa-usd"></i> <span>Sales</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="salesorder.html"> Sales Order</a></li> 
                    </ul>
                </li>

                <li class="menu-list"><a href=""><i class="fa fa-book"></i> <span>Catalogue</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="merchandise.html"> Merchandise</a></li>
                        <li><a href="services.html"> Services</a></li> 
                    </ul>
                </li>
 

                <li class="menu-list"><a href=""><i class="fa fa-bar-chart"></i> <span>Reports</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="#"> Sales Report</a></li>
                        <li><a href="#"> Service Report</a></li>
                        <li><a href="#"> Technician Report</a></li>
                        <li><a href="#"> Referral Report</a></li>
                    </ul>
                </li>

                <li class="menu-list"><a href=""><i class="fa fa-cogs"></i> <span>Settings</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="service-cat.html"> Service Category</a></li>
                        <li><a href="vec-type.html"> Vehicle Type</a></li>
                        <li><a href="uom.html"> Unit of Measurement</a></li>
                        <li><a href="color.html"> Color</a></li> 
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-cog"></i> <span>Account Settings</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="roles.html"> Roles</a></li>
                        <li><a href="users.html"> Users</a></li>
                        <li><a href="branch.html"> Branch</a></li> 
                    </ul>
                </li>
                <!-- <li class="menu-list"><a href="#"><i class="fa fa-user-circle"></i> <span>Administrator</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="#.html"> My Profile</a></li> 
                    </ul>
                </li>
 
                 
                <li><a href="login.html"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li> -->

            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--search start-->
           <!--  <form class="searchform" action="index.html" method="post">
                <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
            </form> -->
            <!--search end-->

            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu"> 
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <img src="images/primex/primex-icon.png" alt="" />
                            Administrator
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="myprofile.html"><i class="fa fa-user"></i>  Profile</a></li> 
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->



        @yield('content')

        <!--footer section start-->
        <footer>
            2017 &copy; PrimeX Auto Detailing
        </footer>
        <!--footer section end-->

    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/jquery.nicescroll.js"></script>

<!--easy pie chart-->
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<script src="js/easypiechart/easypiechart-init.js"></script>

<!--Sparkline Chart-->
<script src="js/sparkline/jquery.sparkline.js"></script>
<script src="js/sparkline/sparkline-init.js"></script>

<!--icheck -->
<script src="js/iCheck/jquery.icheck.js"></script>
<script src="js/icheck-init.js"></script>

<!-- jQuery Flot Chart-->
<script src="js/flot-chart/jquery.flot.js"></script>
<script src="js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="js/flot-chart/jquery.flot.resize.js"></script>
<script src="js/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="js/flot-chart/jquery.flot.selection.js"></script>
<script src="js/flot-chart/jquery.flot.stack.js"></script>
<script src="js/flot-chart/jquery.flot.time.js"></script>
<script src="js/main-chart.js"></script>

<script src="js/scripts.js"></script>

<script type="text/javascript">
    function ajax_error_handling(jqXHR, exception){
        if (jqXHR.status === 0) {
            alert('Not connect.\n Verify Network.');
        } else if (jqXHR.status == 404) {
            alert('Requested page not found. [404]');
        } else if (jqXHR.status == 500) {
            alert('Internal Server Error [500].');
        } else if (exception === 'parsererror') {
            alert('Requested JSON parse failed.');
        } else if (exception === 'timeout') {
            alert('Time out error.');
        } else if (exception === 'abort') {
            alert('Ajax request aborted.');
        } else {
            alert('Uncaught Error.\n' + jqXHR.responseText);
        }
    }
</script>

<!--common scripts for all pages-->
@yield('customJS')


</body>
</html>
