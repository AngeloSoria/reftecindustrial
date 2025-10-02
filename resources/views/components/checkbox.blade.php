@props([
    'id' => uniqid('checkbox-'),
    'name' => '',
    'label' => '',
    'checked' => false
])

<label for="{{ $id }}" class="flex items-center space-x-2 cursor-pointer select-none">
    <!-- Hidden Native Checkbox -->
    <input
        id="{{ $id }}"
        type="checkbox"
        name="{{ $name }}"
        @checked($checked)
        class="peer hidden"
    />

    <!-- Custom Checkbox -->
    <div class="w-4 h-4 border-2 border-gray-400 rounded-sm flex items-center justify-center
                peer-checked:bg-brand-primary peer-checked:border-brand-primary transition duration-200 ease-in-out">
        <!-- Check Icon -->
        @svg('zondicon-checkmark', "w-full h-full text-white peer-checked:block")
    </div>

    <!-- Label -->
    @if($label)
        <span class="text-gray-700">{{ $label }}</span>
    @endif
</label>
