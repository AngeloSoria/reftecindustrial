@props([
    'id' => null,
    'name' => 'content',
    'content' => '',
    'height' => '300px',
])

@php
    // Preserve Alpine-related attributes
    $alpineAttributes = collect($attributes->getAttributes())
        ->filter(fn($value, $key) =>
            str_starts_with($key, 'x-') ||
            str_starts_with($key, '@') ||
            str_starts_with($key, ':')
        )
        ->all();

    // Assign unique editor ID if none provided
    $editorId = $id ?? 'editor-' . uniqid();
@endphp

<div
    id="{{ $editorId }}"
    data-name="{{ $name }}"
    data-content="{{ e($content) }}"
    data-height="{{ $height }}"
    {{ $attributes
        ->except(array_keys($alpineAttributes))
        ->merge([
            'class' => 'quill-editor overflow-hidden'
        ])
        ->merge($alpineAttributes)
    }}
    style="min-width:300px; min-height:100px; height:{{ $height }};"
></div>

{{-- Hidden input for form binding --}}
<input type="hidden" name="{{ $name }}" id="hidden_{{ $editorId }}" value="{{ e($content) }}">
