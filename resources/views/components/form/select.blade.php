@props([
    'label' => null,
    'required' => false,
    'name' => '',
    'model' => '',
    'options' => [],
])

<div class="flex flex-col gap-2">
    @if($label)
        <label class="text-sm font-medium">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <select 
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 
                        transition-colors focus:outline-none'
        ]) }}
        name="{{ $name }}"
        x-model="{{ $model }}"
        @change="updateButtonState()"
    >
        <option disabled value="">Select...</option>

        @foreach($options as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
        @endforeach
    </select>
</div>
