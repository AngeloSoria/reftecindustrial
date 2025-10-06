{{-- Make a switch case for button_type attributes --}}
@php
    $buttonType = $attributes->get('button_type');
    switch ($buttonType) {
        case 'primary':
            $classes = 'bg-accent-orange-300 text-white hover:bg-accent-orange-400';
            break;
        case 'secondary':
            $classes = 'bg-accent-darkslategray-900 text-white hover:bg-accent-darkslategray-800';
            break;
        default:
            $classes = 'bg-white';
            break;
    }
@endphp

@props([
    'href' => null,
    'type' => 'button'
])

@if ($href)
    <a role="button" href="{{ $href }}" class="py-2 px-5 rounded shadow-sm {{ $attributes->get('class') ?? 'transition-colors cursor-pointer' }} {{ $classes }}">
        {{ $slot }}
    </a>
@else
    <button class="py-2 px-4 rounded {{ $attributes->get('class') ?? 'transition-colors cursor-pointer' }} {{ $classes }}">
        {{ $slot }}
    </button>
@endif

