
@props([
    'id' => 'modal-' . uniqid(),
    'clickOutsideToClose' => null, // When user clicks outside the modal, it will close.
    'keyEscapeClose' => null,
    'size' => 'md',
])

@php
    switch ($size) {
        case 'md':
            $modal_size = "max-w-md";
            break;
        case '4xl':
            $modal_size = "max-w-[80%]";
            break;
        case 'full':
            $modal_size = "max-w-full";
            break;
        default:
            $modal_size = "max-w-" . $size;
    }
@endphp

<section
    id="{{ $id }}"
    class="fixed w-full h-screen inset-0 z-100 flex items-center justify-center"
    x-data="{ open: false, projectInfo: {}, }"
    @preview_project_info.window="
        projectInfo = $event.detail.projectInfo
        if (!$event.detail.modalId || $event.detail.modalId !== '{{ $id }}') {
            return;
        }
        open = true;
    "
    x-show="open"
    x-cloak
    >
    {{-- Backdrop --}}
    <div
        id="modal-backdrop"
        class="w-full h-full inset-0 bg-black/40 z-40"
        @if($clickOutsideToClose ?? false)
            @click="open = false"
        @endif
    ></div>

    {{-- Modal --}}
    <div id="modal-content"
        class="absolute bg-white rounded-md shadow-lg w-full {{ $modal_size }} z-50 overflow-y-auto max-h-[90vh]"
        @if($keyEscapeClose ?? false)
             @keydown.escape.window="open = false"
        @endif
        x-show="open"
        x-transition
        >
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-4 shadow-sm">
            <h2 class="text-xl font-bold text-brand-primary-950" >Project Details</h2>
            <button @click="open = false" class="text-gray-600 hover:text-gray-800 cursor-pointer">
                @svg('zondicon-close', 'w-4 h-4')
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-4 flex gap-2 flex-col-reverse md:flex-row">
            {{-- Slideshow --}}
            <x-slideshow size="max-w-md" class="grow" />
            <section class="bg-brand-primary-950 text-white font-inter p-4 grow flex flex-col gap-4 md:max-w-[280px]">
                <p x-text="projectInfo.title" class="font-medium text-2xl text-wrap"></p>
                <p x-text="projectInfo.description" class="font-regular text-sm"></p>
                <span class="flex gap-2 items-center text-sm">
                    Status:
                    <p
                    x-text="projectInfo.status"
                    :class="{
                        'bg-accent-orange-300': projectInfo.status === 'ongoing',
                        'bg-accent-lightscreen-50': projectInfo.status === 'completed'
                    }"
                        class="px-2 py-1 rounded-lg text-white font-medium capitalize text-xs"
                        ></p>
                </span>
                <p x-text="'Date Completed: ' + projectInfo.date" class=" text-sm font-regular"></p>
            </section>
        </div>

        {{-- Modal Footer --}}
        <div class="flex justify-end p-2">
            {{-- <button @click="open = false"
                class="px-4 py-2 bg-accent-orange-300 hover:bg-accent-orange-400 text-white rounded cursor-pointer">
                Close
            </button> --}}
        </div>
    </div>
</section>
