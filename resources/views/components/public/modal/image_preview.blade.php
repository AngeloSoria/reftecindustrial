
@props([
    'id' => 'image-previewer-' . uniqid(),
    'src' => asset('images/reftec_logo_filled.jpg'),
    'escKeyToClose' => null,
    'clickOutsideToClose' => null,
])


<section
    class="fixed inset-0 z-[301] w-full h-screen flex items-center justify-center"
    id="{{ $id }}"
    x-data="{ open: false, previewInfo: {}, }"
    @image_preview_event.window="
        previewInfo = $event.detail.previewInfo;
        if(!previewInfo.image) {
            return;
        }
        open = true;
    "
    x-show="open"
    x-cloak
    @if($escKeyToClose ?? false)
        @keydown.escape.window="open = false"
    @endif
    >

    {{-- Backdrop --}}
    <div
    @if($clickOutsideToClose ?? false)
        @click="open = false"
    @endif
    class="z-40 absolute inset-0 bg-black/75 w-full h-screen"></div>

    {{-- Header --}}
    <div class="z-100 p-4 absolute top-0 right-0 w-full flex items-center justify-end">
        <button
            @click="open = false"
            class="bg-white cursor-pointer hover:bg-gray-200 py-2 px-3 flex items-center gap-2 rounded" title="Close Preview" aria-label="close preview button">
            @svg('zondicon-close', 'w-5 h-5') Close
        </button>
    </div>

    {{-- image container --}}
    <div class="z-50 max-h-[90%] max-w-[90%] rounded-sm flex items-center justify-center absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <img
            class="bg-gray-300 aspect-video"
            x-show="open"
            x-transition
            :src="previewInfo.image" />
    </div>
</section>
