@props([
    'titleHeaderText' => null,
    'enableCloseOnOutsideClick' => true,
    'enableCloseOnEscKeyPressed' => true,
    'modalMaxWidth' => 'md', // md, xl, ... full
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
    class="bg-black/50 backdrop-blur-xs fixed inset-0 w-full h-screen p-4 flex font-inter {{ $flex_default }}"
    x-bind:style="'z-index:' + modal_index + ';'"
    id="{{ $modalID }}"
    x-show="open"
    x-cloak
    x-ref="{{ $modalID }}"
    x-data='{
        modal_id: @json($modalID),
        open: false,
        hasInput: false,
        specialData: {},
        titleHeaderText: @json($titleHeaderText),
        closeEnabled: true,
        modal_index: 0,

        init() {
            // register
            $store.app.modalSystem.registerModal($el);
        },

        closeModal() {
            $store.app.modalSystem.closeModal(this.modal_id);
        },
    }'

    @openmodal.window ='
        const passed_modal_id = $event.detail.modalID

        if(!passed_modal_id) {
            console.error("No modal id passed.");
            return;
        }

        if(passed_modal_id === modal_id) {
            titleHeaderText = $event.detail.title || titleHeaderText;
            open = true;
            modal_index = $event.detail.modalZIndex;
            if($event.detail.payload_data) {
                $dispatch("payload_event", {
                    modalID: modal_id,
                    data: $event.detail.payload_data
                });
            }
        }
    '

    @closemodal.window='
        const passed_modal_id = $event.detail.modalID;
        
        if(!passed_modal_id) {
            console.error("No modal id passed.");
            return;
        }
            
        if(passed_modal_id === modal_id) {
            if(!closeEnabled) {
                console.warn("Modal closing is currently disabled.");
                return;
            }
            if(!open) return;
            open = false;
            $dispatch("modal_closed_fallback", { modalID: modal_id });
        }
    '
    
    @force_disable_modal_closing.window ='
        const passed_modal_id = $event.detail.modalID

        if(!passed_modal_id) {
            console.error("No modal id passed.");
            return;
        }

        if(passed_modal_id === modal_id) {
            closeEnabled = false;
        }
    '
    >

    {{-- modal --}}
    <div
        x-show="open"
        x-transition
        x-cloak

        {{-- @if($enableCloseOnOutsideClick)
            @click.outside="closeModal()"
        @endif --}}
        @if($enableCloseOnEscKeyPressed)
            @keydown.escape.window="closeModal()"
        @endif

        class="p-4 bg-white rounded outline-1 outline-accent-darkslategray-400 w-full h-fit max-w-{{ $modalMaxWidth }} max-h-[95%] overflow-x-hidden overflow-y-auto"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-300/50 pb-2 mb-4">
            <h1 class="text-lg font-medium" x-text="titleHeaderText"></h1>
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
