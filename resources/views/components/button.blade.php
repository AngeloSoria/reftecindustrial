{{-- Make a switch case for button_type attributes --}}
@php
    $buttonType = $attributes->get('button_type');
    switch ($buttonType) {
        case 'primary':
            $classes = 'bg-accent-yellow text-white hover:bg-accent-yellow-darker';
            break;
        case 'secondary':
            $classes = 'bg-accent-black_2 text-white hover:bg-accent-black_2_ligher';
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
    <button class="py-2 px-5 rounded shadow-sm {{ $attributes->get('class') ?? 'transition-colors cursor-pointer' }} {{ $classes }}">
        {{ $slot }}
    </button>
@endif

