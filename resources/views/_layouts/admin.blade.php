<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet" />   
    
    <!-- Custom styles for this template -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">

    <style>
        .sidebar-menu h5 small{
            {{-- color: #bbb; --}}
        }
    </style>

    
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('styles')

</head>
<body>

    <section id="container" >
        @include('_partials.admin.top-nav')
        @include('_partials.admin.left-nav')

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">

            @yield('content')

            </section>
        </section>
        <!--main content end-->

        @include('_partials.admin.footer')

        @yield('modal')        

    </section>


</body>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/js/jquery.scrollTo.min.js"></script>
    <script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="/js/bootstrap-notify.js"></script>

    <script>
        var pathname = window.location.pathname;
        var page = pathname.split('/')[1];

        $('#sidebar .sidebar-menu li a').removeClass('active');
        $('#sidebar .sidebar-menu li[data-page='+page+'] a').addClass('active');

        $('[data-toggle="tooltip"]').tooltip();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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


        $('.btn-delete').click(function(event) {
            event.preventDefault();
            let url = $(this).data('delete-url');
            {{-- console.log(url); --}}
            $.ajax({
                url: url,
                type: 'DELETE',
            })
            .done(function(data) {
                {{-- console.log(data); --}}
                location.reload();
            })
            .fail(function(data) {
                {{-- console.log(data); --}}
                location.reload();
                {{-- showNotification(data['status'], data['data']); --}}
            });        
        });
    </script>

    @yield('scripts')

</html>
