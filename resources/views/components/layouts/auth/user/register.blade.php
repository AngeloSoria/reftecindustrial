<x-layouts.modal modalID="modal_user_register" modalMaxWidth="2xl">
    <form 
        autocomplete="off"
        x-data="registerFormHandler()"
        @submit.prevent="handleSubmit" 
        @modal_closed_fallback.window="handleModalClose($event)"
        action="{{ route('user.add') }}"
        method="POST" enctype="multipart/form-data">
        @csrf

        <section class="grid grid-cols-1 md:grid-cols-1 gap-4">
            {{-- LEFT SIDE --}}
            <section>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">
                            Name
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <input
                            x-model="passContent.name"
                            placeholder="Enter user's name"
                            class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                            name="name" required />
                    </div>
                    
                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">
                            Username
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <input
                            x-model="passContent.username"
                            autocomplete="new-username"
                            placeholder="Enter unique username"
                            class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                            name="username" required />
                    </div>
                </div>
            </section>
            
            <section class="grid grid-cols-2 gap-4">
                
                <div class="flex flex-col gap-2 items-start justify-start">
                    <p class="text-sm font-medium">
                        Password
                        <span class="text-red-500 font-bold">*</span>
                    </p>
                    <input
                        x-model="passContent.pass"
                        autocomplete="new-password"
                        placeholder="Enter password"
                        type="password"
                        class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                        name="password" required />
                </div>
                <div class="flex flex-col gap-2 items-start justify-start">
                    <p class="text-sm font-medium">
                        Confirm Password
                        <span class="text-red-500 font-bold">*</span>
                    </p>
                    <input
                        x-model="passContent.confirm_pass"
                        autocomplete="new-password"
                        placeholder="Enter password again"
                        type="password"
                        class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                        name="password_confirmation" required />
                </div>
            </section>

            <section class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">
                            Role
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <select
                            x-model="passContent.role"
                            class="w-full px-4 py-2 rounded border-2 border-gray-200" name="role" required>
                            <option disabled value="" selected>Select role...</option>
                            {{-- Check if current session is Super Admin role --}}
                            @if(auth()->user()?->role === 'Super Admin')
                                <option value="Super Admin">Super Admin</option>
                            @endif
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
            </section>

        </section>

        {{-- FOOTER BUTTONS --}}
        <section class="flex items-center justify-end gap-2 mt-4">
            <button type="button" :disabled="formDisabled" @click="closeModal()"
                class="cursor-pointer px-5 py-2 rounded bg-gray-300 hover:bg-gray-400">
                Cancel
            </button>

            <button type="submit" :disabled="loading"
                class="cursor-pointer px-5 py-2 flex items-center justify-center gap-2 rounded bg-accent-orange-300 hover:bg-accent-orange-400 disabled:opacity-50 disabled:cursor-not-allowed">

                <template x-if="loading">
                    @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                </template>

                <span x-text="loading ? 'Submitting...' : 'Submit'"></span>
            </button>
        </section>

    </form>

    <script>
        function registerFormHandler() {
            return {
                loading: false,
                formDisabled: false,
                modal_id: "modal_user_register",
                passContent: {
                    name: '',
                    username: '',
                    role: '',
                    pass: '',
                    confirm_pass: '',
                },

                /* ---------------------------
                Modal Event Handling
                ----------------------------*/

                handleModalClose(e) {
                    if (e.detail.modalID !== this.modal_id) return;
                    this.formDisabled = true;

                    this.passContent.name = '';
                    this.passContent.username = '';
                    this.passContent.role = '';
                    this.passContent.pass = '';
                    this.passContent.confirm_pass = '';
                },

                isConfirmPassMatched() {
                    return this.passContent.pass === this.passContent.confirm_pass;
                },

                /* ---------------------------
                Submit
                ----------------------------*/

                handleSubmit() {
                    // if (!this.isConfirmPassMatched()) {
                    //     toast('Password and Confirm Password does not match.', 'error');
                    //     return;
                    // };
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

</x-layouts.modal>