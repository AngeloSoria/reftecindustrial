<section class="flex flex-col gap-4">

    <div class="mb-8">
        <h2 class="font-medium text-lg my-2">Brief History Image</h2>


        <section class="bg-gray-950 w-full flex items-center justify-center">
            <div class="bg-gray-300 max-w-150 w-full aspect-video overflow-hidden">
                {{-- loading icon --}}
                <div id="loading_status_history"
                    class="text-white w-full h-full bg-accent-darkslategray-900 flex flex-col gap-4 justify-center items-center">
                    @svg('antdesign-loading-3-quarters-o', 'w-16 h-16 animate-spin')
                    <h2 class="text-xl font-medium">Loading...</h2>
                </div>
                <img id="image_history" src="{{ asset('images/reftec_logo_transparent.png') }}"
                    class="w-full cursor-pointer aspect-video" title="preview image" x-data="{
                                isLoaded: false,
                                async init() {
                                    try {
                                        const response = await fetch('{{ route('content.get.section.history') }}');
                                        const data = await response.json();

                                        const img = new Image();
                                        img.src = data.data.image;

                                        // Wait until the actual image is fully loaded
                                        img.onload = () => {
                                            this.$refs.historyImg.src = img.src;
                                            this.isLoaded = true;
                                            document.querySelector('#loading_status_history').classList.add('hidden')
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
                                            image: this.$refs.historyImg.src
                                        }
                                    });
                                }
                            }" x-ref="historyImg" @click="preview" />
            </div>
        </section>

        <section class="py-4 flex flex-wrap items-start justify-start">
            <button @click="$dispatch('open_modal', {'modalID':'update_history_section_image'})"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-orange-400 bg-accent-orange-300">
                @svg('fluentui-image-20-o', 'w-5 h-5')
                Update Image
            </button>
        </section>

    </div>

    <hr class="border-gray-300" />

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
                        class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded font-medium bg-accent-lightseagreen-50 hover:bg-accent-lightseagreen-100 text-accent-darkslategray-900 font-inter">
                        @svg('fluentui-edit-20', 'w-4 h-4')
                        Edit Data
                    </button>
                </div>

                <!-- Save + Cancel -->
                <div class="flex gap-2" x-show="editing" x-transition>

                    <div x-data="{ loading: false }">
                        <button id="btn-submit" type="submit" @click="loading = true; $el.form.submit()"
                            :disabled="loading"
                            class="cursor-pointer px-4 py-2 rounded font-medium bg-accent-orange-300 hover:bg-accent-orange-400 text-accent-darkslategray-900 font-inter disabled:opacity-60 disabled:cursor-not-allowed">
                            <span x-show="!loading" class="flex items-center gap-2">
                                @svg('fluentui-save-20', 'w-5 h-5')
                                Save & Update
                            </span>
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

<x-layouts.modal titleHeaderText="Update History Image" modalID="update_history_section_image" promptAlertBeforeClosing>

    {{-- <form action="{{ route('content.add.section.test') }}" method="POST"> --}}
        <form action="{{ route('content.update.section.history') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="flex flex-col gap-2">
                <h4>Upload an image to update hero section backdrop image:</h4>
                <x-layouts.file_upload_drag :hidden-data="['context' => 'content_image']"/>
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
