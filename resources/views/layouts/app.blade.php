<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
</head>
<body>
@yield('content')
<!-- Scripts -->
<!--<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>-->
<script src="{{ asset('js/localization/messages.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>


</body>

</html>
