<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <script src="{{ asset('js/jquery-min.js') }}"></script>
    <title>@yield('title')</title>
</head>

<body>
    <div class="container">
        @yield('content')
    </div>
    @yield('js')
</body>

</html>