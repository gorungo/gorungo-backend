<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
</head>
<body>
<div id="app" class="@yield('color-schema') @yield('background')">
    @yield('header')
    @yield('content')
</div>
<!-- Scripts -->
<script src="{{ asset('js/localization/messages.js') }}"></script>
@guest
    <script src="{{ mix('js/app_guest.js') }}"></script>
@endguest
@auth
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        window.activeUser = @json(\App\User::activeUserResource());
    </script>
@endauth

@yield('scripts')
@stack('scripts')
@include('parts.status')
@include('parts.footer')


</body>

</html>
