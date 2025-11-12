@props([
    'title' => 'Modal Title',
    'show' => false,
    'saveLabel' => 'Save',
    'cancelLabel' => 'Cancel',
    'onSave' => null,
    'onCancel' => null,
])

<div
    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 w-full h-screen p-4"
    x-data="{ open: @js($show) }"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    @openModal.window="open = true"
    >
    <div
        x-transition
        x-show="open"
        @click.away="open = false"
        class="bg-white rounded-md shadow-xl w-full max-w-4xl max-h-full overflow-x-hidden overflow-y-auto"
    >
        <!-- Topbar -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-accent-darkslategray-100">
            <h2 class="text-lg font-medium text-gray-800">{{ $title }}</h2>
            <button
                type="button"
                @click="open = false"
                title="Close"
                class="text-gray-400 hover:text-gray-600 cursor-pointer"
            >
                @svg('zondicon-close', 'w-4 h-4')
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-4">
            <div class="flex flex-col gap-1">
                <label for="input_productLineName" class="text-sm font-medium">Name</label>
                <input
                class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                id="input_productLineName" name="product_line_name" type="text" placeholder="Enter product line name..." required
                aria-required="true" />
            </div>

            <br/>

            <div class="flex flex-col gap-1">
                <label class="text-sm font-medium">Image</label>
                {{-- TODO: FIXME: acceptFile value is not being rendered. --}}
                <x-layouts.file_upload_drag acceptFile="image/*" />
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="flex justify-end gap-2 px-4 py-3 border-t border-accent-darkslategray-100 bg-gray-50">
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
