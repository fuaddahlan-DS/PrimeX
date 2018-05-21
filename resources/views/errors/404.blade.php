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

  <!--Custom CSS -->
  @yield('customCSS')


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>
<body id="page-top" class="index relative-position"> 
    
   
    <!-- About Us Section -->
    <section id="about" class=" relative-position">
        <div class="row "> 

        <img src="/img_/primexlogo.png" alt="PrimeX Detailing" style="width: 100%;">

            <div class="container"> 
                <div class="row">
                    <h2 class="section-heading text-center error ">ERROR</h2>
                </div> 

                <div class="row">
                  <br />
                </div>

                <div class="row">
                    <p class="section-heading text-center" style="font-size: 2em !important;
    margin: 0 !important;">We're sorry. Something went wrong!.</p>
                    <br />
                    <br />
                    <br />
                    <p class="text-center">Click <a href="javascript:history.back()">here</a> to go back</p>
                </div> 
            </div>
        </div>

       
    </section>


    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" integrity="sha384-mE6eXfrb8jxl0rzJDBRanYqgBxtJ6Unn4/1F7q4xRRyIw7Vdg9jP4ycT7x1iVsgb" crossorigin="anonymous"></script>

    <!-- FlexSlider -->
    <script async src="js/jquery.flexslider.js"></script> 
    <script src="js/bmw-script.js"></script> 
    <script src="js/ds-script.js"></script> 
    <!-- Theme JavaScript -->
    <script src="js/agency.js"></script> 
    <script src="js/particles.js"></script>
    <script src="js/script2.js"></script>  
    <script src="js/demo.js"></script> 
    <script src=js/smooth.js></script>

  <script type="text/javascript"> 
      var $window, $document, $body;

      $window = $(window);
      $document = $(document);
      $body = $("body");

      $window.bind("resizeEnd", function () {
            $("#about").height($window.height());
        });

        $window.resize(function () {
            if (this.resizeTO) clearTimeout(this.resizeTO);
            this.resizeTO = setTimeout(function () {
                $(this).trigger("resizeEnd");
            }, 300);
        }).trigger("resize");
  </script>
 
</body>

</html>
 

