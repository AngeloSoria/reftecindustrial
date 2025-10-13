@props([
    'icon' => 'fluentui-person-16-o',
    'iconColor' => 'bg-brand-secondary-300',
    'label' => '<<PUT LABEL HERE>>',

    'counter' => '0',
    'change' => '0',
    'ratio' => '0',
    'ratioType' => null, // increase | decrease | neutral | null

])

@php
    $textColor;
    $changeIcon;
    $ratioIcon;
    switch($ratioType) {
        case 'increase':
            $textColor = 'text-accent-lightseagreen-50';
            $changeIcon = 'fluentui-chevron-double-up-16';
            $ratioIcon = 'fluentui-arrow-trending-20';
            break;
        case 'decrease':
            $textColor = 'text-brand-secondary-300';
            $changeIcon = 'fluentui-chevron-double-down-16';
            $ratioIcon = 'fluentui-arrow-trending-down-20';
            break;
        case 'neutral':
            $textColor = 'text-accent-accent-orange-300';
            $changeIcon = 'fluentui-equal-circle-20';
            $ratioIcon = 'fluentui-equal-circle-20';
            break;
        default:
            $textColor = 'text-red-500';
            $changeIcon = 'fluentui-error-circle-20';
            $ratioIcon = 'fluentui-error-circle-20';
    }
@endphp

<div class="bg-white px-4 py-5 rounded-xl shadow-md inline-block font-inter {{ $attributes->get('class') }}">
    <div class="bg-green-300/0 min-w-[150px] flex flex-col gap-1">

        {{-- icon --}}
        <div class="{{ $iconColor }} rounded-full p-2 w-fit">
            @svg($icon, 'w-6 h-6 text-white')
        </div>

        {{-- counter --}}
        <div class="flex items-center gap-3">
            <p class="text-2xl font-bold">{{ $counter }}</p>
            <div class="{{ $textColor }} flex items-center gap-1">
                {{-- up/low icon value --}}
                @svg($changeIcon, 'w-4 h-4')
                {{ $change }}
            </div>
        </div>

        {{-- label --}}
        <p class="text-sm font-medium text-accent-darkslategray-600">{{ $label }}</p>

        {{-- ratio --}}
        <div class="{{ $textColor }} flex items-center text-sm gap-2 font-medium">
            {{-- increase/decrease icon value --}}
            @svg($ratioIcon, 'w-6 h-6')
            <p>{{ $ratio }}&percnt;</p>
        </div>
    </div>
</div>
