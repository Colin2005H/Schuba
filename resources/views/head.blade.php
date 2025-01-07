<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-blue-900 justify-items-center">

<!-- <div class="container bg-blue-400"> -->
    @yield('content')
<!-- </div> -->

</body>
</html>
