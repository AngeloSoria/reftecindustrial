<x-layouts.modal modalID="modal_projects_public" modalMaxWidth="4xl">
    <section x-data="projectsModalController()" @payload_event.window="setProjectData($event.detail)">
        <section class="w-full grid grid-cols-1 md:grid-cols-[65%_1fr] gap-2">
            
            <x-public.slideshow2 slideshow_id="ss_projects_public" />

            <div class="shadow-card font-inter p-4 flex flex-col gap-1">
                <h2 class="text-2xl font-bold text-brand-primary-950" x-text="projectData ? projectData.title : ''"></h2>
                <span class="flex gap-2 items-center text-sm mb-2">
                    <p
                    x-text="projectData ? projectData.status : ''"
                    :class="{
                        'bg-accent-orange-300': projectData && projectData.status === 'on_going',
                        'bg-accent-lightseagreen-50 text-white': projectData && projectData.status === 'completed'
                    }"
                    class="px-2 py-1 rounded-lg font-medium text-xs uppercase"></p>
                </span>
                <p class="text-sm text-gray-700 mt-2" x-text="projectData ? projectData.description : ''"></p>
            </div>

        </section>
        <script>
            function projectsModalController() {
                return {
                    projectData: null,
                    setProjectData(data) {
                        if (!data || !data.data) {
                            // console.error('Invalid project data received:', data);
                            return;
                        }
                        // console.log(data.data);
                        this.projectData = data.data.project_data;
                        // console.log('Project Data Set:', this.projectData.images);
                        
                        // slideshow setup
                        this.$nextTick(() => {
                            window.dispatchEvent(
                                new CustomEvent('slideshow:set', {
                                    detail: {
                                        slideshow_id: 'ss_projects_public',
                                        images: this.projectData.images ?? []
                                    }
                                })
                            );
                        });
                    }
                };
            }
        </script>
    </section>
</x-layouts.modal>