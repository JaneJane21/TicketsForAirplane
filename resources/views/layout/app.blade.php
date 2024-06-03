<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('public\css\bootstrap.css') }}">
    <link rel="icon" href="{{ asset('public\images\icon.png') }}" type="image/x-icon">

</head>
<body>

<script src="{{ asset('public\js\bootstrap.bundle.js') }}"></script>
@include('layout.navbar')
@yield('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.5/vue.global.js"></script>
</body>
</html>
