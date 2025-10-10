@props([
    'minHeight' => 'min-h-screen'
])

<section class="max-w-6xl mx-auto {{ $minHeight }}">
    {{ $slot }}
</section>
