<h2 class="font-medium text-lg mb-2">About Us</h2>
<div class="">
    <h2>Gallery</h2>

    <section class="py-2 flex">
        <button @click="$dispatch('openmodal', {
            modalID: 'modal_about_us_gallery',
            modal_header_text: 'Add Gallery Image',
        })"
            class="py-2 px-5 rounded shadow-sm bg-accent-orange-300 text-white hover:bg-accent-orange-400 transition-colors cursor-pointer">
            <span class="flex items-center gap-2">
                @svg('fluentui-add-circle-20-o', 'w-5 h-5')
                Add Image
            </span>
        </button>
    </section>

    <p class="text-sm text-gray-600 italic py-2">
        Note: Hold the drag icon <span class="inline-block">@svg('fluentui-drag-24-o', 'w-5 h-5')</span> to reorder
        images in the gallery.
    </p>

    {{-- TODO: Complete this api-sided gallery rendering. --}}
    <ul
        id="sortable-container_about_gallery"
        x-data="{
            isMobile: window.innerWidth < 768,
            loading: true,
            galleryImages: [],
            async init() {
                // fetch gallery images from API and populate the list
                const response = await fetch('{{ route('content.get.section.about_us.gallery') }}');
                const data = await response.json();
                console.log(data);
                if(data.success) {
                    this.galleryImages = data.gallery_images;
                } else {
                    console.error('Failed to load gallery images.');
                }
                this.loading = false;
                // TODO: Continue here...
            },
        }"
        class="p-2 bg-accent-darkslategray-300 rounded gap-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">

        {{-- <template x-for="">

        </template> --}}

        @for ($i = 0; $i < 3; $i++)
            <li
                class="relative p-1 bg-accent-darkslategray-100 border-12 border-white rounded-lg shadow-sm min-w-[33%] min-h-[200px]"
                data-id="sortable_item_{{ $i }}"
                title="Drag to change order."
                x-data="{ isHovered: false }"
                @mouseover="isHovered = true"
                @mouseleave="isHovered = false"
                >

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
                                    gallery_id: {{ $i }},
                                },
                            }
                        )"
                        title="Edit Image"
                        class="p-2 rounded-full cursor-pointer shadow-sm hover:bg-gray-200 bg-white text-black/90 hover:text-black">
                        @svg('fluentui-edit-24-o', 'w-4 h-4')
                    </button>

                    <button title="Hold and Drag to Reorder"
                        class="drag-handle flex items-center justify-start gap-1 p-2 rounded-full cursor-pointer shadow-sm hover:bg-gray-200 bg-white text-black/90 hover:text-black">
                        @svg('fluentui-drag-24-o', 'w-4 h-4')
                    </button>
                </div>
            </li>
        @endfor

    </ul>

</div>

<x-layouts.modal modalID="modal_about_us_gallery" modalMaxWidth="md">
    <section
    x-data="{
        modal_id: 'modal_about_us_gallery',
        galleryData: null,
    }"
    @passed_product_data.window="
        if (!$event.detail.data) { console.error('No data passed.') }
        if (!event.detail.modalID) { console.error('No modal ID passed. \n modal_id: ' + modal_id); }
        if ($event.detail.modalID !== modal_id) { return }
        galleryData = $event.detail.data;
    "
    @modal_closed_fallback.window="
        if($event.detail.modalID !== modal_id ) { return }
        galleryData = null;
    ">
        <template x-if="galleryData">
            <p x-text="galleryData.gallery_id"></p>
        </template>
        <x-layouts.file_upload_drag />
    </section>
</x-layouts.modal>
