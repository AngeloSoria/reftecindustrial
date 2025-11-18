<div x-data="{
        controlButtonsVisible: false,
        loading: true,
        galleryImages: [],
        async init() {
            // fetch gallery images from API and populate the list
            const response = await fetch('{{ route('content.get.section.about_us.gallery') }}');
            const data = await response.json();
            console.log(data);
            if(data.success) {
                this.galleryImages = data.data;
            } else {
                console.error('Failed to load gallery images.');
            }
            this.loading = false;
        },
    }">
    <h2>Gallery</h2>

    <section class="py-2 flex">
        <x-public.button button_type="primary" @click="
            $dispatch('openmodal', {
                modalID: 'modal_about_us_gallery',
                modal_header_text: 'Add Gallery Image',
            });
            controlButtonsVisible = !controlButtonsVisible;
            ">
            <span class="flex items-center gap-2">
                @svg('fluentui-add-circle-20-o', 'w-5 h-5')
                Add Image
            </span>
        </x-public.button>
    </section>

    <p class="text-sm text-gray-600 italic py-2">
        Note: Hold the drag icon <span class="inline-block">@svg('fluentui-drag-24-o', 'w-5 h-5')</span> to reorder
        images in the gallery.
    </p>

    {{-- TODO: Complete this api-sided gallery rendering. --}}
    <ul id="sortable-container_about_gallery" x-data="{
            isMobile: window.innerWidth < 768,
        }"
        :class="galleryImages && galleryImages.length <= 0 ? 'p-6 flex justify-start items-center' : 'p-2  grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2'"
        class="bg-gray-200 border rounded">

        <template x-if="galleryImages.length <= 0">
            <div class="opacity-[50%] italic">No images uploaded...</d>
        </template>

        <template x-if="galleryImages && galleryImages.length > 0">

            <span>
                <template x-for="image in galleryImages">
                    <li class="relative p-1 bg-accent-darkslategray-100 border-12 border-white rounded-lg shadow-sm min-w-[33%] min-h-[200px]"
                        data-id="sortable_item_test" title="Drag to change order." x-data="{ isHovered: false }"
                        @mouseover="isHovered = true" @mouseleave="isHovered = false">
                        <p x-text="image"></p>

                        <img src="{{ asset('images/bulan.jpg') }}" class="w-full h-full aspect-video object-contain" />

                        <!-- Controls: Visible on hover (desktop) + always visible on mobile -->
                        <div x-show="isHovered || isMobile" x-transition
                            class="flex items-center justify-end gap-2 absolute bottom-0 left-0 w-full p-2">

                            <button @click="$dispatch(
                                    'openmodal',
                                    {
                                        modalID: 'modal_about_us_gallery',
                                        modal_header_text: 'Edit Gallery Image',
                                        special_data: {
                                            gallery_id: image,
                                        },
                                    }
                                )" title="Edit Image"
                                class="p-2 rounded-full cursor-pointer shadow-sm hover:bg-gray-200 bg-white text-black/90 hover:text-black">
                                @svg('fluentui-edit-24-o', 'w-4 h-4')
                            </button>

                            <button title="Hold and Drag to Reorder"
                                class="drag-handle flex items-center justify-start gap-1 p-2 rounded-full cursor-pointer shadow-sm hover:bg-gray-200 bg-white text-black/90 hover:text-black">
                                @svg('fluentui-drag-24-o', 'w-4 h-4')
                            </button>
                        </div>
                    </li>
                </template>
            </span>

        </template>

    </ul>

    <section x-transition x-show="controlButtonsVisible" x-data class="mt-2 py-2 flex justify-end items-center">
        <form method="POST" action="{{ route('content.add.section.test') }}">
            @csrf
            <input id="about_us_gallery_input_order" type="hidden" name="about_us_gallery_order" value="[]" />

            <section class="flex items-center gap-2">
                <x-public.button type="button">
                    <span class="flex items-center justify-center gap-2">
                        Cancel
                    </span>
                </x-public.button>
                <x-public.button button_type="primary" type="submit">
                    <span class="flex items-center justify-center gap-2">
                        @svg('fluentui-save-20', 'w-5 h-5')
                        Save Changes
                    </span>
                </x-public.button>
            </section>

        </form>
    </section>


</div>

<x-layouts.modal modalID="modal_about_us_gallery" modalMaxWidth="md">
    @php
        $fileUploadId = 'file_upload_about_us_gallery';
    @endphp
    <form x-data="{
        modal_id: 'modal_about_us_gallery',
        file_upload_id: @js($fileUploadId),
        galleryData: {},
        formDisabled: true,
        loading: false,
        routes: {
            add: '{{ route('content.add.section.about_us.gallery') }}',
            edit: ''
        },
    }"
    @submit.prevent="
        loading = true;
        if(formDisabled) {
            toast('all required fields in the form must have value first.', 'warning');
            return;
        }
        $dispatch('force_disable_modal_closing', { modalID: modal_id });
        $dispatch('form_in_submit_phase', { file_upload_id: file_upload_id });
        $el.submit();
    "
    @passed_product_data.window="
        if (!$event.detail.data) { console.error('No data passed.') }
        if (!event.detail.modalID) { console.error('No modal ID passed. \n modal_id: ' + modal_id); }
        if ($event.detail.modalID !== modal_id) { return }
        galleryData = $event.detail.data;
    " @modal_closed_fallback.window="
        if($event.detail.modalID != modal_id) return;
        galleryData = {};
        $dispatch('reset_file_upload', { file_upload_id: file_upload_id });
    " @files_empty.window="
        if($event.detail.file_upload_id != file_upload_id) return;
        formDisabled = true;
    " @files_not_empty.window="
        if($event.detail.file_upload_id != file_upload_id) return;
        formDisabled = false;
    "
    method="POST"
    enctype="multipart/form-data"
    :action="galleryData && Object.keys(galleryData).length > 0 ? routes.edit : routes.add"
    >
        @csrf
        <template x-if="galleryData">
            <p x-text="galleryData.gallery_id"></p>
        </template>

        <x-layouts.file_upload_drag file_upload_id="{{ $fileUploadId }}" acceptFile="image/*" multiple maxUploadCount="3" />

        <section class="mt-4 flex items-center justify-end gap-2">
            <button type="button" @click="closeModal()" :disabled="loading"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-darkslategray-300 bg-accent-darkslategray-200">
                Cancel
            </button>
            <button type="submit" :disabled="loading || formDisabled"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-orange-400 bg-accent-orange-300 disabled:opacity-50 disabled:cursor-not-allowed">
                <template x-if="loading">
                    @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                </template>
                <span x-text="loading ? 'Saving...' : 'Save'"></span>
            </button>
        </section>

    </form>
</x-layouts.modal>
