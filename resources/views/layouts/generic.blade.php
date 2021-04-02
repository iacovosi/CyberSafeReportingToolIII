<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">

    @yield('css')

</head>

<body>

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery.validate.min.js') }}"></script> --}}

    @yield('scripts')

</body>
</html>
