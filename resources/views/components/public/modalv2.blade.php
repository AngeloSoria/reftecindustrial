@props([
    'modalID' => uniqid('modal_id_'),
])

<div
    x-data="{ id: '{{ $modalID }}' }"
    x-show="$store.modalStack.isOpen(id)"
    x-trap="$store.modalStack.top() === id"
    x-transition.opacity
    class="fixed inset-0 flex items-center justify-center"
    :style="`z-index: ${$store.modalStack.zIndex(id)}`"
>

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50"
         @click="$store.modalStack.close(id)"
         :style="`z-index: ${$store.modalStack.zIndex(id)}`">
    </div>

    <!-- Modal box -->
    <div class="relative bg-white p-6 rounded-lg shadow-xl"
         :style="`z-index: ${$store.modalStack.zIndex(id) + 1}`"
         @click.stop
    >
        {{ $slot }}

        <button class="absolute top-3 right-3"
            @click="$store.modalStack.close(id)">
            ✕
        </button>
    </div>
</div>
