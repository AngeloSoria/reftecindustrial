@props([
    'title' => 'Modal Title',
    'show' => false,
    'saveLabel' => 'Save',
    'cancelLabel' => 'Cancel',
    'onSave' => null,
    'onCancel' => null,
])

<div
    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50"
    x-data="{ open: @js($show) }"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    @open-modal.window="open = true"
    >
    <div
        x-transition
        x-show="open"
        @click.away="open = false"
        class="bg-white rounded-md shadow-xl w-full max-w-md overflow-hidden"
    >
        <!-- Topbar -->
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
            <button
                type="button"
                @click="open = false"
                class="text-gray-400 hover:text-gray-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-4">
            {{ $slot }}
        </div>

        <!-- Footer Buttons -->
        <div class="flex justify-end gap-2 px-4 py-3 border-t bg-gray-50">
            <button
                type="button"
                @click="{{ $onCancel ? $onCancel : 'open = false' }}"
                class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border rounded-lg hover:bg-gray-100"
            >
                {{ $cancelLabel }}
            </button>
            <button
                type="button"
                @click="{{ $onSave ?? '' }}"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
            >
                {{ $saveLabel }}
            </button>
        </div>
    </div>
</div>
