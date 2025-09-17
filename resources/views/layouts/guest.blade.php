<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Css -->
    <link href="{{ asset('bootstrap/font/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-5">
            <div class="text-center mb-3">
                <a href="/">
                    <x-application-logo class="fill-current" style="width: 5.314em" />
                </a>
            </div>
            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
