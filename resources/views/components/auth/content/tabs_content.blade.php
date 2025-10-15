@props([
    'id' => uniqid('tab-content-'),
])

<div id="general" class="tab-content mt-6 {{ $attributes->get('class') }}">
    {{ $slot }}
</div>
