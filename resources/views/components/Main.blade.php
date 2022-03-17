<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$_PAGE_TITLE}} | @yield('title', '*** TITLE ***')</title>
    
    @yield('components.Stylesheets')

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container-scroller">
        @yield('components.Navbar')

        <div class="container-fluid page-body-wrapper">
            @yield('components.Sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content', '*** CONTENT ***')
                </div>

                @yield('components.Footer')
            </div>
        </div>
    </div>

    @yield('components.Scripts')
</body>
</html>