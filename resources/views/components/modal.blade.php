@props([
    'id' => 'dynamicModal',
    'maxWidth' => 'max-w-lg',
])

<div x-data="{ open: false, modalTitle: '', modalContent: '' }"
    @open-modal.window="
    if (!$event.detail.modalID || $event.detail.modalID !== '{{ $id }}') return;
        modalTitle = $event.detail.title;
        modalContent = $event.detail.content;
        open = true;
    "
    x-show="open" x-cloak id="{{ $id }}"
    class="fixed w-full h-screen top-0 left-0 inset-0 z-100 flex items-center justify-center">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

    <!-- Modal -->
    <div class="relative w-full {{ $maxWidth }} p-6 bg-white rounded-sm shadow-xl transition"
        @keydown.escape.window="open = false" x-show="open" x-transition>
        <!-- Title -->
        <h2 class="text-lg font-semibold mb-4" x-text="modalTitle"></h2>

        <!-- Content -->
        <div class="mb-4" x-html="modalContent"></div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 mt-4">
            <button class="px-4 py-2 bg-gray-300 rounded cursor-pointer hover:bg-gray-400" @click="open = false">
                Close
            </button>
        </div>
    </div>
</div>
