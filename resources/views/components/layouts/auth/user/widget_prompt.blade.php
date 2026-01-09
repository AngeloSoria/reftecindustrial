<x-layouts.modal modalID="modal_user_widget_prompt" modalMaxWidth="md">
    <section 
        x-data="menuFormHandler()"
        @payload_event.window="loadUserData($event)"
        >
        <div class="flex flex-col gap-4">
            <button 
                @click="
                    $store.app.modalSystem.openModal('modal_user_update', {
                        title: 'Update User',
                        payload: {
                            user_data: payload,
                        },
                    });
                    closeModal();
                "
                class="cursor-pointer transition-all p-2 w-full rounded-sm bg-gray-300 shadow-card hover:bg-gray-200 active:bg-gray-400">
                Update Info
            </button>
            <button
                @click="
                    $store.app.modalSystem.openModal('modal_user_deactivate', {
                        title: 'Deactivate User',
                        payload: {
                            user_data: payload,
                        },
                    });
                    closeModal();
                "
                class="cursor-pointer transition-all p-2 w-full rounded-sm bg-gray-300 shadow-card hover:bg-gray-200 active:bg-gray-400">
                <span class="text-red-400">
                    Deactivate User
                </span>
            </button>
        </div>

    <script>
        function menuFormHandler() {
            return {
                payload: null,
                loadUserData(e) {
                    this.payload = e.detail.data.user_data;
                },
            }
        }
    </script>
    </section>
</x-layouts.modal>