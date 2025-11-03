<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Admin Dashboard')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/png" href="{{ asset('storage/logo/logotomohon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo/logotomohon.png') }}">
    </head>
    <body class="min-h-screen bg-white font-sans text-slate-900 antialiased lg:pl-64 xl:pl-72">
        <div class="min-h-screen">
            @yield('body')
        </div>
        <div class="toast-container" data-toast-root></div>
        @stack('scripts')
    </body>
</html>
