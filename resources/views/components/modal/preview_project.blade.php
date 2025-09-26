@props([
    'id' => 'modal-' . uniqid(),
    'title' => null,
])

<section
    id="{{ $id }}"
    class="fixed w-full h-screen inset-0 z-100 flex items-center justify-center"
    x-data="{ open: false }"
    x-show="open"
    x-cloak
    @event_showModal.window="
        console.log($event.detail.modalId);
        if(!$event.detail.modalId || $event.detail.modalId !== '{{ $id }}') return;
        open = true
    "
    >
    {{-- Backdrop --}}
    <div
        id="modal-backdrop"
        class="w-full h-full inset-0 bg-black/50 z-40"
        @click="open = false"
    ></div>

    {{-- Modal --}}
    <div id="modal-content"
        class="absolute bg-white rounded-md shadow-lg w-11/12 md:w-2/3 lg:w-1/2 xl:w-1/3 z-50 overflow-y-auto max-h-[90vh]">
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-xl font-semibold">Project Preview</h2>
            <button onclick="closeModal('{{ $id }}')" class="text-gray-600 hover:text-gray-800 cursor-pointer">
                @svg('zondicon-close', 'w-4 h-4')
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-4">
            <p>test</p>
            {{-- Add your modal content here --}}
        </div>

        {{-- Modal Footer --}}
        <div class="flex justify-end p-4 border-t">
            <button onclick="closeModal('{{ $id }}')"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg cursor-pointer hover:bg-blue-700">
                Close
            </button>
        </div>
    </div>
</section>
