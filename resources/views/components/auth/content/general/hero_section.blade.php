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
    <x-public.button button_type="primary" @click="$dispatch('openmodal', {'modalID':'update_hero_section_image'})">
        @svg('fluentui-image-20-o', 'w-5 h-5')
        Update Image
    </x-public.button>
</section>

<x-layouts.modal titleHeaderText="Update Hero Image" modalID="update_hero_section_image" promptAlertBeforeClosing>
    <section>
        <form 
        @php
            $fileUploadId = 'file_upload_hero';
        @endphp
        x-data="{
            modal_id: 'update_hero_section_image',
            loading: false,
            formDisabled: true,
            file_upload_id: @js($fileUploadId),
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
        @modal_closed_fallback.window="
            if($event.detail.modalID !== modal_id ) { return }
            $dispatch('reset_file_upload', { file_upload_id: file_upload_id });
        "
        @files_empty.window="
            if($event.detail.file_upload_id != file_upload_id) return;
            formDisabled = true;
        "
        @files_not_empty.window="
            if($event.detail.file_upload_id != file_upload_id) return;
            formDisabled = false;
        "
        action="{{ route('content.update.section.hero') }}"
        method="POST" 
        enctype="multipart/form-data">
            @csrf
            <section class="flex flex-col gap-2">
                <h4>Upload an image to update hero section backdrop image:</h4>
                <x-layouts.file_upload_drag 
                    acceptFile="image/*" 
                    file_upload_id="{{ $fileUploadId }}" 
                    modalMaxWidth="md" />
            </section>
            <section class="mt-6 flex items-center justify-end gap-2">
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
    </section>
</x-layouts.modal>