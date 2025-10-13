@props([
    'viewName' => null
])

<!DOCTYPE html>
<html lang="en">
<x-partials.head />

<body class="bg-gray-200">
    <x-auth.navbar :viewName="$viewName"/>

    <main>
        {{ $slot }}
    </main>
</body>

</html>
