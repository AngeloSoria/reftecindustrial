<button class="{{ $attributes->get('class') ?? $default_class }}">
    {{ $slot }}
</button>
{{-- <button class="px-4 py-2 rounded font-extrabold {{ $attributes->get('class') }}">
    {{ $slot }}
</button> --}}