<!-- basic template -->


<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Document</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    @if (Auth::check())
        <a href="auth/logout" style="float: right; padding-right: 2cm">logout</a>
    @endif
    @yield('head')
</head>

<body>
    <div class="container">
        @yield('content')
    </div>

    @yield('footer')

</body>
</html>

