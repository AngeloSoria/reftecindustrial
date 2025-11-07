@props([
    'name' => uniqid('switch_'),
    'id' => uniqid('switch_id_'),
    'checkedColor' => 'bg-green-500',
    'size' => 'sm',
    'customStateValue' => false,
    'label' => null,
])

@php
    $maxWidth = '';
    switch($size){
        case 'xxs':
            $maxWidth = 'max-w-[20px]';
            break;
        case 'xs':
            $maxWidth = 'max-w-[40px]';
            break;
        case 'sm':
        default:
            $maxWidth = 'max-w-[60px]';
            break;
        case 'md':
            $maxWidth = 'max-w-[80px]';
            break;
        case 'lg':
            $maxWidth = 'max-w-[100px]';
            break;
    }
@endphp

<section
    x-data="{
        checked: @js($customStateValue),
        init() {
            console.log('switch_toggle loaded.');
        },
    }"
    @update_switch_state.window="
        console.log('switch_toggle called!');
        if(!$event.detail.id) return;

        if(@js($id) === $event.detail.id) {
            checked = $event.detail.state;
        }
    "
    class="w-full flex items-center gap-2"
>
    <div
        class="w-full {{ $maxWidth }}"
    >
        <input
            type="hidden"
            :value="checked ? '1' : '0'"
            @if($name ?? false) name="{{ $name }}" @endif
            @if($id ?? false) id="{{ $id }}" @endif
            />

        <div
            @click="checked = !checked"
            class="relative flex items-center bg-gray-300 rounded-full cursor-pointer transition-colors duration-300"
            :class="checked ? '{{ $checkedColor }}' : 'bg-gray-300'"
            style="aspect-ratio: 2 / 1;"
        >
            <!-- Knob -->
            <div
                class="absolute top-1/2 left-[5%] w-[40%] aspect-square bg-white rounded-full shadow-md transition-all duration-300 transform -translate-y-1/2"
                :class="checked ? 'translate-x-[125%]' : 'translate-x-0'"
            ></div>
        </div>
    </div>
    @if ($label ?? false)
        <label for="{{ $id }}" @click="checked = !checked" class="text-sm">{{ $label }}</label>
    @endif
</section>
