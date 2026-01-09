<x-layouts.modal modalID="modal_delete_project" modalMaxWidth="md">
    <section x-data="deleteProjectForm()" @modal_closed_fallback.window="handleModalClose($event)">
        <section>
            <h2>Project Info:</h2>

            <section class="p-2 bg-gray-200 rounded">
                <div class="flex gap-2">
                    <p class="font-bold">Job Order:</p>
                    <span x-text="projectData.job_order"></span>
                </div>
                <div class="flex gap-2">
                    <p class="font-bold">Title:</p>
                    <span x-text="projectData.title"></span>
                </div>
                <div class="flex gap-2">
                    <p class="font-bold">Status:</p>
                    <span x-text="projectData.status"></span>
                </div>
            </section>

        </section>
        <section>
            <form method="POST" @payload_event.window="loadProjectData($event);" @submit.prevent="formSubmit()"
                x-data action="{{ route('content.delete.section.project') }}">
                @csrf
                <input type="hidden" name="project_id" x-bind:value="projectData.id" />
                <div class="mt-4 flex justify-end items-start gap-2">
                    <x-public.button type="button" button_type="default" x-bind:disabled="formDisabled"
                        @click="closeModal()">
                        Cancel
                    </x-public.button>
                    <x-public.button type="submit" x-bind:disabled="loading"
                        class="cursor-pointer text-white bg-red-500 hover:bg-red-400 active:bg-red-600 transition-colors disabled:opacity-50 flext items-center justify-center gap-2">
                        <template x-if="loading">
                            @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                        </template>
                        <span x-text="loading ? 'Deleting...' : 'Delete'"></span>
                    </x-public.button>
                </div>
            </form>
        </section>
        <script>
            function deleteProjectForm() {
                return {
                    projectData: {},
                    loading: false,
                    formDisabled: false,

                    formSubmit() {
                        this.loading = true;
                        this.formDisabled = true;

                        window.dispatchEvent(new CustomEvent("force_disable_modal_closing", {
                            detail: { modalID: 'modal_delete_project' }
                        }));

                        this.$el.submit();
                    },

                    handleModalClose(e) {
                        if (e.detail.modalID !== this.modal_id) return;
                        this.projectData = {};
                    },

                    loadProjectData(e) {
                        if (!e.detail.data) return;
                        if (e.detail.modalID !== this.modal_id) return;
                        this.projectData = e.detail.data.product_data;
                    },
                }
            }
        </script>
    </section>
</x-layouts.modal>