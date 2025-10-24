

@props([
    'titleHeaderText' => null,
    'enableCloseOnOutsideClick' => true,
    'enableCloseOnEscKeyPressed' => true,
    'modalMaxWidth' => 'xl', // md, xl, ... full
    'modalID' => uniqid('modal_'),
    'promptAlertBeforeClosing' => false,
    'modalPosition' => 'center-center',
])

@php
    $flex_position;
    switch($modalPosition){
        case 'top-left':
            $flex_default = 'items-start justify-start';
            break;
        case 'top-right':
            $flex_default = 'items-start justify-end';
            break;
        case 'top-center':
            $flex_default = 'items-start justify-center';
            break;
        case 'bottom-left':
            $flex_default = 'items-end justify-start';
            break;
        case 'bottom-right':
            $flex_default = 'items-end justify-end';
            break;
        case 'bottom-center':
            $flex_default = 'items-end justify-center';
            break;
        case 'center-center':
        default:
            $flex_default = 'items-center justify-center';
            break;
    }
@endphp

<section
    id="{{ $modalID }}"
    x-show="modalOpen"
    x-cloak
    x-data='{
        modal_id: "{{ $modalID }}",
        modalOpen: false,
        closeModal() {
            if(passed_modal_id !== this.modal_id) { return; }
            if(@json($promptAlertBeforeClosing)) {
                if(!confirm("Closing this modal will reset all progress.")) { return; }
                    this.modalOpen = false;

                    const modalElement = document.getElementById(this.modal_id);
                    if (!modalElement) return;

                    // Reset all physical form elements
                    modalElement.querySelectorAll("input, textarea, select").forEach(el => {
                        switch (el.type) {
                            case "checkbox":
                            case "radio":
                                el.checked = false;
                                break;
                            case "file":
                                el.value = null;
                                break;
                            default:
                                el.value = "";
                                break;
                        }
                    });
            } else {
                this.modalOpen = false;
            }
        },
    }'
    @open_modal.window="
        passed_modal_id = $event.detail.modalID
        if(!passed_modal_id) {
            console.error('No modal id passed.');
            return;
        }
        if(passed_modal_id === modal_id) {
            modalOpen = true;
        }
    "
    class="z-[300] bg-black/50 backdrop-blur-xs fixed inset-0 w-full h-screen p-4 flex font-inter {{ $flex_default }}"
>

    {{-- modal --}}
    <div
    x-show="modalOpen"
    x-transition
    x-cloak

    @if($enableCloseOnOutsideClick)
        @click.away.window="closeModal()"
    @endif
    @if($enableCloseOnEscKeyPressed)
        @keydown.escape.window="closeModal()"
    @endif

    class="p-4 bg-white rounded outline-1 outline-accent-darkslategray-400 w-full h-fit max-w-{{ $modalMaxWidth }} overflow-x-hidden overflow-y-auto"
    >
    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-300/25">
        <h1 class="text-xl font-medium">{{ $titleHeaderText }}</h1>
        <div class="">
            <button
                title="Close"
                @click="closeModal()"
                class="p-1 rounded-full cursor-pointer text-black/50 hover:text-black outline-gray-400/25 hover:outline-1">
                @svg('zondicon-close', 'w-4 h-4')
            </button>
        </div>
    </div>

        {{ $slot }}

    </div>

</section>

