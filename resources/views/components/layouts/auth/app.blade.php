@props([
    'viewName' => null
])

<!DOCTYPE html>
<html lang="en">
<x-partials.head />

 <body>
    <x-auth.navbar :viewName="$viewName"/>

    <main class="{{ $attributes->get('class') }} max-w-7xl mx-auto">
        {{ $slot }}
    </main>

    <x-public.btn_backtotop scrollDetectValue="200" />

</body>
</html>
