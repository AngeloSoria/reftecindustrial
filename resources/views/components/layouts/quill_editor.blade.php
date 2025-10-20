@php
    // Collect all Alpine-related attributes (x-*, @*, :)
    $alpineAttributes = collect($attributes->getAttributes())
        ->filter(function ($value, $key) {
            return str_starts_with($key, 'x-')
                || str_starts_with($key, '@')
                || str_starts_with($key, ':');
        })
        ->mapWithKeys(fn($value, $key) => [$key => $value])
        ->all(); // ✅ convert to plain array
@endphp

<div id="{{ $attributes->get('id') }}" {{ $attributes->except(array_keys($alpineAttributes))->merge(['class' => 'quill-editor min-w-[300px] min-h-[100px]'])->merge($alpineAttributes) }}>
</div>
