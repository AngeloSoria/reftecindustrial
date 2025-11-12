@props([
    'titleHeaderText' => null,
    'enableCloseOnOutsideClick' => true,
    'enableCloseOnEscKeyPressed' => true,
    'modalMaxWidth' => 'xl', // md, xl, ... full
    'modalID' => uniqid('modal_'),
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
    class="z-[300] bg-black/50 backdrop-blur-xs fixed inset-0 w-full h-screen p-4 flex font-inter {{ $flex_default }}"
    id="{{ $modalID }}"
    x-show="open"
    x-cloak
    x-ref="mainModal_{{ $modalID }}"
    x-data='{
        modal_id: @json($modalID),
        open: false,
        hasInput: false,
        specialData: {},
        titleHeaderText: @json($titleHeaderText),

        closeModal() {
            this.open = false;
            $dispatch("modal_closed_fallback", { modalID: this.modal_id });
        },
    }'

    @openmodal.window ='
        const passed_modal_id = $event.detail.modalID

        if(!passed_modal_id) {
            console.error("No modal id passed.");
            return;
        }

        if(passed_modal_id === modal_id) {
            titleHeaderText = $event.detail.modal_header_text || titleHeaderText;
            open = true;
            if($event.detail.special_data) {
                $dispatch("passed_product_data", { data: $event.detail.special_data });
            }
        }'

    @set_modal_header_text.window ='
        const passed_modal_id = $event.detail.modalID

        if(!passed_modal_id) {
            console.error("No modal id passed.");
            return;
        }

        if(passed_modal_id === modal_id && $event.detail.text) {
            titleHeaderText = $event.detail.text;
            console.log("Modal header text set to:", titleHeaderText);
        }
    '
    >

    {{-- modal --}}
    <div
        x-show="open"
        x-transition
        x-cloak

        @if($enableCloseOnOutsideClick)
            @click.away.window="closeModal()"
        @endif
        @if($enableCloseOnEscKeyPressed)
            @keydown.escape.window="closeModal()"
        @endif

        {{-- x-bind:special_data="special_data" --}}

        class="p-4 bg-white rounded outline-1 outline-accent-darkslategray-400 w-full h-fit max-w-{{ $modalMaxWidth }} max-h-[95%] overflow-x-hidden overflow-y-auto"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-300/50 pb-2 mb-4">
            <h1 class="text-xl font-medium" x-text="titleHeaderText"></h1>
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
