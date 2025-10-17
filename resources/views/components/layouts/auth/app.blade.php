@props([
    'viewName' => null
])

<!DOCTYPE html>
<html lang="en">
<x-partials.head />

<body class="bg-gray-200">
    <x-auth.navbar :viewName="$viewName"/>

    <main class="{{ $attributes->get('class') }}">
        {{ $slot }}
    </main>

    <x-public.btn_backtotop scrollDetectValue="200" />
</body>

</html>
