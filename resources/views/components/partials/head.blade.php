<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="title" content="Reftec Industrial Supply & Services Inc.">
    <meta name="description"
        content="The main business is installing ice plants and cold storages and fabricating ice plant components. It also supplies and installs commercial water tanks and other services related to water industry and …">
    <meta name="keywords"
        content="refrigeration, construction, industrial, supply, reftec, reftec industrial, water system, cold storage, water tanks">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">


    {{-- FavIcon --}}
    <link rel="shortcut icon" href="{{ asset('images/logo_favicon_64x64_3.png') }}" type="image/x-icon">

    <title>{{ $title ?? config('app.name', 'Laravel Project') }}</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@if(session('toasts'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @foreach(session('toasts') as $toast)
                toast(@json($toast['message']), @json($toast['type']), @json($toast['duration']));
            @endforeach
            });
    </script>
@endif


<x-public.toast />