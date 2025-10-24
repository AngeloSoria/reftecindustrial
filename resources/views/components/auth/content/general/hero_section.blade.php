<h2 class="font-medium text-lg mb-4">Hero Section Backdrop Image</h2>

{{-- Hero section image preview --}}
<div class="bg-gray-300 rounded max-w-150 w-full aspect-video overflow-hidden">
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

<section class="mt-4 flex flex-col gap-2">
    <h4>Upload an image to update hero section backdrop image:</h4>
    <x-layouts.file_upload_drag action="{{ route('content.update.section.hero') }}" uploadMultiple="false"
        class="max-w-md" />
</section>

