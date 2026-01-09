<x-layouts.modal modalID="modal_delete_projects" modalMaxWidth="2xl">
    <section x-data="deleteProjectsForm()" @modal_closed_fallback.window="handleModalClose($event)">
        <section>
            <h2>
                <span x-text="Object.keys(projectData).length"></span>
                Projects Info:
            </h2>

            <section class="p-2 bg-gray-200 rounded grid grid-cols-2 gap-2 max-h-[400px] overflow-y-auto">
                <template x-if="projectData && Object.keys(projectData).length > 0">
                    <template x-for="(project, index) in projectData" :key="project + '_' + index">
                        <section class="bg-gray-100 rounded-sm shadow-card p-3 w-full h-full flex flex-col gap-2">
                            <div class="flex gap-2">
                                <p class="font-sans font-medium text-sm">Job Order:</p>
                                <span x-text="project.job_order"></span>
                            </div>
                            <div class="flex gap-2">
                                <p class="font-sans font-medium text-sm">Status:</p>
                                <template x-if="project.status == 'pending'">
                                    <div class="scale-[80%] max-w-fit relative grid items-center font-sans font-bold uppercase whitespace-nowrap select-none bg-orange-400/20 text-orange-600 py-1 px-2 text-xs rounded-md"
                                        style="opacity: 1;">
                                        <span class="text-center">Pending</span>
                                    </div>
                                </template>
                                <template x-if="project.status == 'on_going'">
                                    <div class="scale-[80%] max-w-fit relative grid items-center font-sans font-bold uppercase whitespace-nowrap select-none bg-yellow-400/20 text-yellow-600 py-1 px-2 text-xs rounded-md"
                                        style="opacity: 1;">
                                        <span class="text-center">On Going</span>
                                    </div>
                                </template>
                                <template x-if="project.status == 'completed'">
                                    <div class="scale-[80%] max-w-fit relative grid items-center font-sans font-bold uppercase whitespace-nowrap select-none bg-green-400/20 text-green-600 py-1 px-2 text-xs rounded-md"
                                        style="opacity: 1;">
                                        <span class="text-center">Completed</span>
                                    </div>
                                </template>
                                {{-- <span x-text="project.status"></span> --}}
                            </div>
                            <div class="flex gap-2">
                                <p class="font-sans font-medium text-sm">Title:</p>
                                <span x-text="project.title" class="text-sm"></span>
                            </div>
                        </section>
                    </template>
                </template>
            </section>

        </section>
        <section>
            <form method="POST" action="{{ route('content.delete.section.projects.selected') }}"
                @payload_event.window="loadProjectData($event);" @submit.prevent="formSubmit()">
                @csrf
                <input type="hidden" name="projects" x-bind:value="JSON.stringify(projectData)" />
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
            function deleteProjectsForm() {
                return {
                    projectData: {},
                    loading: false,
                    formDisabled: false,

                    formSubmit() {
                        this.formDisabled = false;
                        this.loading = true;
                        this.$el.submit();
                        // $dispatch('force_disable_modal_closing', { modalID: 'modal_delete_projects' });
                        window.dispatchEvent(new CustomEvent("force_disable_modal_closing", {
                            detail: { modalID: 'modal_delete_projects' }
                        }));
                    },

                    handleModalClose(e) {
                        if (e.detail.modalID !== this.modal_id) return;
                        this.projectData = {};
                        this.formDisabled = true;
                    },

                    loadProjectData(e) {
                        if (!e.detail.data) return;
                        if (e.detail.modalID !== this.modal_id) return;
                        this.projectData = e.detail.data.project_data;
                        console.log(this.projectData);
                    },
                }
            }
        </script>
    </section>
</x-layouts.modal>