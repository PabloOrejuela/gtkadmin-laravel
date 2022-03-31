<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/styles.css')}}" type="text/css" rel="stylesheet">
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <title>@yield('title')</title>
    <style>
        .active {
	color:#349428;
	font-weight: bold;
}
    </style>
</head>
<body>
    @include('layouts.partials.header')

    @yield('content')
</body>
</html>
