<?php 
    use App\Http\Controllers\RolesAccessController;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="/images/primex/primex-icon.png" type="image/png">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Dashboard - PrimeX Management</title>

  <!--icheck-->
  <link type="text/css" href="/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link type="text/css" href="/js/iCheck/skins/square/square.css" rel="stylesheet">
  <link type="text/css" href="/js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="/js/iCheck/skins/square/blue.css" rel="stylesheet">

  <!--dashboard calendar-->
  <link type="text/css" href="/css/clndr.css" rel="stylesheet">


  <!--common-->
  <link type="text/css" href="/css/style.css" rel="stylesheet">
  <link type="text/css" href="/css/style-responsive.css" rel="stylesheet">
  
  <!--toastr-->
  <link href="/css/toastr.css" rel="stylesheet"/>
  
  <!--Choosen-->
  <link  href="/vendor/chosen_v1.8.2/chosen.css" rel="stylesheet">

  <!--Custom CSS -->
  @yield('customCSS')


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  
  <!-- Placed js at the end of the document so the pages load faster -->
 <script src="/js/jquery-1.10.2.min.js"></script> 
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="{{ url('home') }}"><img src="/images/primex/primexlogo.png" alt="PrimeX Auto Detailing" class="img-responsive"></a>
        </div>

        <div class="logo-icon text-center">
            <a href="{{ url('home') }}"><img src="/images/primex/primex-icon.png" alt="PrimeX Auto Detailing" class="img-responsive"></a>
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
                        <li><a href="{{url('sales-list')}}"> Sales Order</a></li> 
                    </ul>
                </li>

                <li id="catalogues" class="menu-list {{Request::is('catalogues-merchandises*')|Request::is('catalogues-services*') ? 'nav-active' : '' }}"><a href=""><i class="fa fa-book"></i> <span>Catalogues</span></a>
                    <ul class="sub-menu-list">
                        <li id="catalogues-merchandises" class="{{Request::is('catalogues-merchandises*') ? 'active' : '' }}"><a href="{{url('catalogues-merchandises')}}"> Merchandises</a></li>
                        <li id="catalogues-services" class="{{Request::is('catalogues-services*') ? 'active' : '' }}"><a href="{{url('catalogues-services')}}"> Services</a></li>
                    </ul>
                </li>
 

                <!--<li class="menu-list"><a href=""><i class="fa fa-bar-chart"></i> <span>Reports</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="#"> Sales Report</a></li>
                        <li><a href="#"> Service Report</a></li>
                        <li><a href="#"> Technician Report</a></li>
                        <li><a href="#"> Referral Report</a></li>
                    </ul>
                </li>-->

                <li id="settings" class="menu-list {{Request::is('settings-service-categories*')|Request::is('settings-vehicle-types*')|Request::is('settings-unit-of-measurements*')|Request::is('settings-colors*') ? 'nav-active' : '' }}"><a href=""><i class="fa fa-cogs"></i> <span>Settings</span></a>
                    <ul class="sub-menu-list">
                        <li id="settings-service-categories" class="{{Request::is('settings-service-categories*') ? 'active' : '' }}"><a href="{{url('settings-service-categories')}}"> Service Categories</a></li>
                        <li id="settings-vehicle-types" class="{{Request::is('settings-vehicle-types*') ? 'active' : '' }}"><a href="{{url('settings-vehicle-types')}}"> Vehicle Types</a></li>
                        <li id="settings-unit-of-measurements" class="{{Request::is('settings-unit-of-measurements*') ? 'active' : '' }}"><a href="{{url('settings-unit-of-measurements')}}"> Unit of Measurements</a></li>
                        <li id="settings-colors" class="{{Request::is('settings-colors*') ? 'active' : '' }}"><a href="{{url('settings-colors')}}"> Colors</a></li> 
                    </ul>
                </li>
                <li id="accountsettings" class="menu-list {{Request::is('accountsettings-roles')|Request::is('accountsettings-users')|Request::is('accountsettings-branches')|Request::is('accountsettings-roles/*')|Request::is('accountsettings-users/*')|Request::is('accountsettings-branches/*') ? 'nav-active' : '' }}"><a href=""><i class="fa fa-cog"></i> <span>Account Settings</span></a>
                    <ul class="sub-menu-list">
                        <li id="accountsettings-roles" class="{{Request::is('accountsettings-roles')|Request::is('accountsettings-roles/*') ? 'active' : '' }}"><a href="{{url('accountsettings-roles')}}"> Roles</a></li>
                        <li id="accountsettings-users" class="{{Request::is('accountsettings-users')|Request::is('accountsettings-users/*') ? 'active' : '' }}"><a href="{{url('accountsettings-users')}}"> Users</a></li>
                        <li id="accountsettings-branches" class="{{Request::is('accountsettings-branches')|Request::is('accountsettings-branches/*') ? 'active' : '' }}"><a href="{{url('accountsettings-branches')}}"> Branches</a></li> 
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
                            <img src="/images/primex/primex-icon.png" alt="" />
                            {{ Auth::user()->name }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="/backend-html/myprofile.html"><i class="fa fa-user"></i>  Profile</a></li> 
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


<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>-->

<script src="/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/modernizr.min.js"></script>
<script src="/js/jquery.nicescroll.js"></script>

<!--toastr-->
<script src="/js/toastr.js"></script>
<!--Choosen-->
<script src="/vendor/chosen_v1.8.2/chosen.jquery.js" type="text/javascript"></script>

<!--easy pie chart-->
<script src="/js/easypiechart/jquery.easypiechart.js"></script>
<script src="/js/easypiechart/easypiechart-init.js"></script>

<!--Sparkline Chart-->
<script src="/js/sparkline/jquery.sparkline.js"></script>
<script src="/js/sparkline/sparkline-init.js"></script>

<!--icheck -->
<script src="/js/iCheck/jquery.icheck.js"></script>
<script src="/js/icheck-init.js"></script>

<!-- jQuery Flot Chart-->
<!--<script src="/js/flot-chart/jquery.flot.js"></script>
<script src="/js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="/js/flot-chart/jquery.flot.resize.js"></script>
<script src="/js/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="/js/flot-chart/jquery.flot.selection.js"></script>
<script src="/js/flot-chart/jquery.flot.stack.js"></script>
<script src="/js/flot-chart/jquery.flot.time.js"></script>
<script src="/js/main-chart.js"></script>-->

<script src="/js/scripts.js"></script>

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

<script type="text/javascript">
 ///CHOSEN////
 $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
////END CHOSEN////
    $(window).load(function() {
        
        <?= RolesAccessController::checkCataloguesView(); ?>
        <?= RolesAccessController::checkSettingsView(); ?>
        <?= RolesAccessController::checkAccountSettingsView(); ?>
    });
    
    
</script>
</body>
</html>
