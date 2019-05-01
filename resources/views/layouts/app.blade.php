<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @yield('header')
    @yield('content')
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
{{--<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>--}}

@yield('scripts')
@stack('scripts')
@include('parts.status')
@include('parts.footer')

</body>

</html>
