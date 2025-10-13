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
</body>

</html>
