@props([
    'label' => null,
    'name' => '',
    'model' => '',
])

<div class="flex flex-col gap-2">
    @if($label)
        <label class="text-sm font-medium">{{ $label }}</label>
    @endif

    <textarea
        {{ $attributes->merge([
            'class' => 'w-full min-h-34 max-h-40 px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 
                        transition-colors focus:outline-none'
        ]) }}
        name="{{ $name }}"
        x-model="{{ $model }}"
        @input="updateButtonState()"
    ></textarea>
</div>
