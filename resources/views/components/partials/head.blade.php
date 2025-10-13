<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- FavIcon --}}
    <link rel="shortcut icon" href="{{ asset('images/logo_favicon_64x64_3.png') }}" type="image/x-icon">

    <title>{{ $title ?? config('app.name', 'Laravel Project') }}</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
