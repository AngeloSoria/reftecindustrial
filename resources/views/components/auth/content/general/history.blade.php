<section class="flex flex-col gap-4" x-data="
    {
        isLoaded: false,
        history: {},
        editing: false,
        quill: null,
        toolbar: null,
        originalContent: '',
        init() {
            $watch('generalContentsLoaded', (value) => {
                if (historyData && historyData.success) {
                    this.history.image = historyData.data.image;
                    this.history.description = historyData.data.description;

                    if (this.quill) {
                        this.quill.root.innerHTML = this.history.description || '';
                        this.originalContent = this.history.description || '';
                        this.quill.enable(false);
                        this.quill.root.setAttribute('contenteditable', false);
                    }

                    this.isLoaded = true;
                }
            });

            document.addEventListener('quill-initialized', () => {
                this.quill = window.quills?.['editor-history'] ?? null;
                if (this.quill) {
                    this.toolbar = this.quill.getModule('toolbar')?.container;
                    if (this.toolbar) this.toolbar.style.display = 'none';
                }
            });
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
        },
    }
    ">
    <div class="mb-8">
        <h2 class="font-medium text-lg my-2">Brief History Image</h2>
        <section class="bg-gray-950 w-full flex items-center justify-center">
            <div class="bg-gray-300 max-w-150 w-full aspect-video overflow-hidden">
                {{-- loading icon --}}
                <div class="text-white w-full h-full bg-accent-darkslategray-900 flex flex-col gap-4 justify-center items-center"
                    id="loading_status_history" x-show="!isLoaded">
                    @svg('antdesign-loading-3-quarters-o', 'w-16 h-16 animate-spin')
                    <h2 class="text-xl font-medium">Loading...</h2>
                </div>
                <img class="w-full cursor-pointer aspect-video" id="image_history"
                    src="{{ asset('images/reftec_logo_transparent.png') }}" title="preview image" x-data
                    x-show="isLoaded" x-bind:src="history.image" @click="$dispatch('image_preview_event', {
                        previewInfo: {
                            image: this.$refs.historyImg.src
                        }
                    })" />
            </div>
        </section>

        <section class="py-4 flex flex-wrap items-start justify-start">
            <x-public.button button_type="primary"
                @click="$dispatch('openmodal', {'modalID':'update_history_section_image'})">
                @svg('fluentui-image-20-o', 'w-5 h-5')
                Update Image
            </x-public.button>
        </section>

    </div>

    <hr class="border-gray-300" />

    <div class="flex flex-col gap-2 mt-8">
        <h2 class="font-medium text-xl my-2">Brief History Text</h2>
        <form x-data action="{{ route('content.update.section.history') }}" method="POST" class="flex flex-col gap-2">
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

    <section>
        @php
            $fileUploadId = 'file_upload_history';
        @endphp
        <form x-data="{
                modal_id: 'update_history_section_image',
                loading: false,
                formDisabled: true,
                file_upload_id: @js($fileUploadId),
            }" @submit.prevent="
                loading = true;
                if(formDisabled) {
                    toast('all required fields in the form must have value first.', 'warning');
                    return;
                }
                $dispatch('force_disable_modal_closing', { modalID: modal_id });
                $dispatch('form_in_submit_phase', { file_upload_id: file_upload_id });
                $el.submit();
            " @modal_closed_fallback.window="
                if($event.detail.modalID != modal_id) return;
                $dispatch('reset_file_upload', { file_upload_id: file_upload_id });
            " @files_empty.window="
                if($event.detail.file_upload_id != file_upload_id) return;
                formDisabled = true;
            " @files_not_empty.window="
                if($event.detail.file_upload_id != file_upload_id) return;
                formDisabled = false;
            " action="{{ route('content.update.section.history') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="flex flex-col gap-2">
                <h4>Upload an image to update hero section backdrop image:</h4>
                <x-layouts.file_upload_drag file_upload_id="{{ $fileUploadId }}"
                    :hidden-data="['context' => 'content_image']" acceptFile="image/*" />
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