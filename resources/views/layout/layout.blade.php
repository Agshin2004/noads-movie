<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    {{-- Serving the compiled version of resources/css/app.css using Vite (with PostCSS and Tailwind) --}}
    {{--
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}"> --}}
    {{-- * MUST USE OFFICIAL BLADE DIRECTIVE (example above is right as well) --}}
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css" />
    @livewireStyles
    @stack('styles')
    <title>ZMA Movie</title>
</head>

<body class="text-white ">
    @include('partials.navbar')
    <main class="">
        @yield('content')

    </main>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    @vite('resources/js/app.js')
    @livewireScripts
    @include('partials.footer')
    @stack('scripts')
</html>
