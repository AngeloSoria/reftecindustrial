<h2 class="font-medium text-lg mb-4">Hero Section Backdrop Image</h2>

{{-- Hero section image preview --}}
<section class="bg-gray-950 w-full flex items-center justify-center">
    <div class="bg-gray-300 max-w-150 w-full aspect-video overflow-hidden">
        {{-- loading icon --}}
        <div id="loading_status_hero"
            class="text-white w-full h-full bg-accent-darkslategray-900 flex flex-col gap-4 justify-center items-center">
            @svg('antdesign-loading-3-quarters-o', 'w-16 h-16 animate-spin')
            <h2 class="text-xl font-medium">Loading...</h2>
        </div>
        <img id="image_hero" src="{{ asset('images/reftec_logo_transparent.png') }}"
            class="w-full cursor-pointer aspect-video" title="preview image" x-data="{
            isLoaded: false,
            async init() {
                try {
                    const response = await fetch('{{ route('content.get.section.hero') }}');
                    const data = await response.json();

                    const img = new Image();
                    img.src = data.data.image;

                    // Wait until the actual image is fully loaded
                    img.onload = () => {
                        this.$refs.heroImg.src = img.src;
                        this.isLoaded = true;
                        document.querySelector('#loading_status_hero').classList.add('hidden')
                    };
                } catch (e) {
                    console.error('Failed to load hero image:', e);
                }
            },
            preview() {
                if (!this.isLoaded) {
                    console.warn('Image not ready yet');
                    return;
                }
                this.$dispatch('image_preview_event', {
                    previewInfo: {
                        image: this.$refs.heroImg.src
                    }
                });
            }
        }" x-ref="heroImg" @click="preview" />
    </div>
</section>

<section class="py-4 flex flex-wrap items-start justify-start">
    <button @click="$dispatch('open_modal', {'modalID':'update_hero_section_image'})"
        class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-orange-400 bg-accent-orange-300">
        @svg('fluentui-image-20-o', 'w-5 h-5')
        Update Image
    </button>
</section>

<x-layouts.modal titleHeaderText="Update Hero Image" modalID="update_hero_section_image" promptAlertBeforeClosing>

    {{-- <form action="{{ route('content.add.section.test') }}" method="POST"> --}}
        <form action="{{ route('content.update.section.hero') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="flex flex-col gap-2">
                <h4>Upload an image to update hero section backdrop image:</h4>
                <x-layouts.file_upload_drag />
            </section>
            <section class="mt-6 flex items-center justify-end gap-2">
                <button type="button" @click="closeModal()"
                    class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-darkslategray-300 bg-accent-darkslategray-200">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-orange-400 bg-accent-orange-300">
                    Submit
                </button>
            </section>
        </form>

</x-layouts.modal>
