<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Serving the compiled version of resources/css/app.css using Vite (with PostCSS and Tailwind) --}}
    {{--
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}"> --}}
    {{--* MUST USE OFFICIAL BLADE DIRECTIVE (example above is right as well) --}}
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <title>ZMA Movie</title>
</head>

<body class="text-white">
    @include('partials.navbar')
    @yield('content')

    @vite('resources/js/app.js')

</body>

</html>