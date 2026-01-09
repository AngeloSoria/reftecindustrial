<x-layouts.modal modalID="modal_user_deactivate" modalMaxWidth="md">
    <form
        x-data="deactivateUserFormHandler()"
        @payload_event.window="loadUserData($event)"
        @submit.prevent="handleSubmit()"
        method="POST"
        action="{{ route('user.archive') }}"
    >
        @csrf
        <div>
            <h2>Do you want to deactivate this user?</h2>
            <template x-if="user">
                <div class="">
                    <input type="hidden" name="id" :value="user.id" />
                    <p>
                        <span>User ID:</span>
                        <span x-text="user.id" class="font-medium font-sans"></span>
                    </p>
                    <p>
                        <span>Name:</span>
                        <span x-text="user.name" class="font-medium font-sans"></span>
                    </p>
                    <p>
                        <span>Username:</span>
                        <span x-text="user.username" class="font-medium font-sans"></span>
                    </p>
                    <p>
                        <span>Role:</span>
                        <span x-text="user.role" class="font-medium font-sans"></span>
                    </p>
                </div>
            </template>
        </div>

        {{-- FOOTER BUTTONS --}}
        <section class="flex items-center justify-end gap-2 mt-4">
            <button type="button" :disabled="formDisabled" @click="closeModal()"
                class="cursor-pointer px-5 py-2 rounded bg-gray-300 hover:bg-gray-400">
                Cancel
            </button>

            <button type="submit" :disabled="isLoading"
                class="cursor-pointer px-5 py-2 flex items-center justify-center gap-2 rounded bg-accent-orange-300 hover:bg-accent-orange-400 disabled:opacity-50 disabled:cursor-not-allowed">

                <template x-if="isLoading">
                    @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                </template>

                <span x-text="isLoading ? 'Submitting...' : 'Submit'"></span>
            </button>
        </section>

        <script>
            function deactivateUserFormHandler() {
                return {
                    modal_id: 'modal_user_deactivate',
                    user: null,
                    formDisabled: false,
                    isLoading: false,
                    loadUserData(e) {
                        const user_data = e.detail.data.user_data;
                        console.log(user_data);
                        if (!user_data) return;
                        this.user = user_data;
                    },
                    handleSubmit() {
                        this.formDisabled = true;
                        this.loading = true;
                        window.dispatchEvent(new CustomEvent("force_disable_modal_closing", {
                            detail: { modalID: this.modal_id }
                        }));
                        this.$el.submit();
                    },
                };
            }
        </script>
    </form>
</x-layouts.modal>