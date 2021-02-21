<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('meta-title',config('app.name')." más velocidad")</title>
        <meta name="description" content="@yield('meta-content','El internet más veloz para ver el nuevo servicio de streaming que tanto esperas. Videollamadas que no se traban incluso en galaxias muy muy lejanas.')">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta name="author" content="Adrián Núñez Alanis">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>

        <div id="app"></div>

        <script> window.acceptC = false; </script>
        <script src="{{ asset(mix('js/app.js')) }}"></script>
    </body>
</html>
