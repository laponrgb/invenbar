<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @props(['titlePage' => null])
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ($titlePage ? $titlePage . ' - ' : '') . config('app.name', 'InvenBar') }}</title>

    <link href="{{ asset('bootstrap/font/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-vh-100 bg-light pb-2">
        @include('layouts.navigation')

        @if ($titlePage)
            <header class="bg-white shadow-sm">
                <div class="container py-4">
                    <h2 class="h5 mb-0">
                        {{ $titlePage }}
                    </h2>
                </div>
            </header>
        @endif

        <main class="container">
            <div class="my-5">
                {{ $slot }}
            </div>
        </main>
    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
