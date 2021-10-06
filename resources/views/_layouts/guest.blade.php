<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>{{ config('app.name') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

      <div id="login-page">
        <div class="container">
        
            @yield('content')      
        
        </div>
      </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap-notify.js"></script>
    <script>
        $.backstretch("assets/img/Life-of-Pix-free-stock-photos-sunset-sea-light-mikewilson.jpeg", {speed: 500});
    </script>

    <script>
      function showNotification(theme, text){
            var icon, type;
            if(theme == 'success'){
                icon = 'fa fa-check';
                type = theme;
            } else if(theme == 'danger'){
                icon = 'fa fa-close';
                type = theme;
            }

            $.notify({
                icon: icon,
                message: text

            },{
                type: type,
                timer: 4000
            });
        }

        // var errors;
        {{-- @foreach($errors->all() as $error)
            console.log("{{$error}}");
            showNotification('danger', "{{$error}}");
        @endforeach --}}

        // Show Errors
        @if($errors->any())
            @foreach($errors->all() as $error)
                {{-- console.log("{{$error}}"); --}}
                showNotification('danger', "{{$error}}");
            @endforeach
        @endif

        // Show Session Flash Message
        @if(session('success'))
            showNotification('success', "{{session('success')}}");
        @endif

        @if(session('fail'))
            showNotification('danger', "{{session('fail')}}");
        @endif
    </script>


  </body>
</html>
