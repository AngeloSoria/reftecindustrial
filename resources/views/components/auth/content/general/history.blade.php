<section class="flex flex-col gap-4">

<div class="mb-8">
    <h2 class="font-medium text-xl my-2">Brief History Image</h2>

    {{-- Hero section image preview --}}
    <div class="bg-gray-300 rounded max-w-150 w-full aspect-video overflow-hidden">
        <img id="image_hero" src="{{ asset('images/reftec_logo_transparent.png') }}"
            class="w-full cursor-pointer aspect-video" title="preview image" x-data="{
            isLoaded: false,
            async init() {
                try {
                    const response = await fetch('{{ route('content.get.section.history') }}');
                    const data = await response.json();

                    if(data.data.image) {
                        const img = new Image();
                        img.src = data.data.image;

                        // Wait until the actual image is fully loaded
                        img.onload = () => {
                            this.$refs.heroImg.src = img.src;
                            this.isLoaded = true;
                        };
                    }
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
        <x-layouts.file_upload_drag
            action="{{ route('content.update.section.history') }}"
            :hidden-data="['context' => 'content_image']"
            class="max-w-md" />
    </section>

</div>

<hr class="border-gray-300"/>

<div class="flex flex-col gap-2 mt-8">
    <h2 class="font-medium text-xl my-2">Brief History Text</h2>
    <form action="{{ route('content.update.section.history') }}" method="POST" class="flex flex-col gap-2" x-data="{
        editing: false,
        quill: null,
        toolbar: null,
        originalContent: '',

        async init() {
            const response = await fetch('{{ route('content.get.section.history') }}');
            const data = await response.json();

            this.quill = window.quills ? window.quills['editor-history'] : null;

            if (this.quill) {
                this.quill.root.innerHTML = data.data.description || '';
                this.originalContent = data.data.description || '';

                this.toolbar = this.quill.getModule('toolbar')?.container;
                if (this.toolbar) this.toolbar.style.display = 'none';

                this.quill.enable(false);
                this.quill.root.setAttribute('contenteditable', false);
            }
        },

        toggleEditing(state) {
            this.editing = state;

            if (this.quill) {
                // Toggle editor
                this.quill.enable(state);
                this.quill.root.setAttribute('contenteditable', state);

                // Toggle toolbar visibility
                if (this.toolbar) {
                    this.toolbar.style.display = state ? 'block' : 'none';
                }

                // Reset content on cancel
                if (!state) {
                    this.quill.root.innerHTML = this.originalContent;
                }
            }
        }
    }">
        @csrf

        <!-- Quill Editor -->
        <x-layouts.quill_editor id="editor-history" name="data_history" :content="''" />

        {{-- Hidden --}}
        <input type="hidden" name="context" value="content_text" />

        <!-- Buttons -->
        <div class="flex flex-col gap-2 mt-4">
            <!-- Edit -->
            <div class="flex gap-2" x-show="!editing">
                <button type="button" @click="toggleEditing(true)"
                    class="cursor-pointer px-4 py-2 rounded font-medium bg-accent-lightseagreen-50 hover:bg-accent-lightseagreen-100 text-accent-darkslategray-900 font-inter">
                    Edit Data
                </button>
            </div>

            <!-- Save + Cancel -->
            <div class="flex gap-2" x-show="editing" x-transition>

                <div x-data="{ loading: false }">
                    <button id="btn-submit" type="submit" @click="loading = true; $el.form.submit()" :disabled="loading"
                        class="cursor-pointer px-4 py-2 rounded font-medium bg-accent-orange-300 hover:bg-accent-orange-400 text-accent-darkslategray-900 font-inter disabled:opacity-60 disabled:cursor-not-allowed">
                        <span x-show="!loading">Save & Update</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            @svg('mdi-loading', 'animate-spin w-4 h-4 text-accent-darkslategray-900')
                            Saving...
                        </span>
                    </button>
                </div>


                <button type="button" @click="toggleEditing(false)"
                    class="cursor-pointer px-4 py-2 rounded font-medium bg-brand-secondary-300 hover:bg-brand-secondary-400 text-accent-darkslategray-900 font-inter">
                    Cancel
                </button>
            </div>
        </div>
    </form>
</div>

</section>

