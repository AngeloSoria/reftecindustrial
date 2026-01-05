<x-layouts.modal modalID="modal_user_update" modalMaxWidth="2xl">
    <form 
        autocomplete="off"
        x-data="updateUserFormHandler()"
        @submit.prevent="handleSubmit" 
        @passed_product_data.window="loadUserData($event)"
        @modal_closed_fallback.window="handleModalClose($event)"
        action="{{ route('user.update') }}"
        method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" :value="passContent.id" />

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

            <section>
                <template x-if="updatePassEnabled">
                    <input type="hidden" name="update_pass_enabled" x-bind:value="updatePassEnabled" />
                </template>
                <section class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">
                            Password
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <input
                            :disabled="!updatePassEnabled"
                            x-model="passContent.pass"
                            autocomplete="new-password"
                            placeholder="Enter password"
                            type="password"
                            class="w-full px-4 py-2 rounded border-2 disabled:bg-gray-300 disabled:cursor-not-allowed border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                            name="password" required />
                    </div>
                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">
                            Confirm Password
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <input
                            :disabled="!updatePassEnabled"
                            x-model="passContent.confirm_pass"
                            autocomplete="new-password"
                            placeholder="Enter password again"
                            type="password"
                            class="w-full px-4 py-2 rounded border-2 disabled:bg-gray-300 disabled:cursor-not-allowed border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                            name="password_confirmation" required />
                    </div>
                </section>
                <section class="mt-2 flex items-top justify-start">
                    <button
                        :disabled="formDisabled"
                        type="button" 
                        @click="updatePassEnabled = !updatePassEnabled"
                        :class="!updatePassEnabled ? 'bg-blue-400 hover:bg-blue-500' : 'bg-red-400 hover:bg-red-500'"
                        class="cursor-pointer py-1 px-2 rounded transition-all" >
                        <span x-text="!updatePassEnabled ? 'Edit Password' : 'Cancel'"></span>
                    </button>
                </section>
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
        function updateUserFormHandler() {
            return {
                loading: false,
                formDisabled: false,
                updatePassEnabled: false,
                modal_id: "modal_user_update",
                passContent: {
                    id: 0,
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
                    this.formDisabled = false;
                    
                    this.updatePassEnabled = false;

                    this.passContent.id = 0;
                    this.passContent.name = '';
                    this.passContent.username = '';
                    this.passContent.role = '';
                    this.passContent.pass = '';
                    this.passContent.confirm_pass = '';
                },

                isConfirmPassMatched() {
                    return this.passContent.pass === this.passContent.confirm_pass;
                },

                loadUserData(e) {
                    if (!e.detail.data) return;
                    if (e.detail.modalID !== this.modal_id) return;
                    this.passContent.id = e.detail.data.user_data.id;
                    this.passContent.name = e.detail.data.user_data.name;
                    this.passContent.username = e.detail.data.user_data.username;
                    this.passContent.role = e.detail.data.user_data.role;
                    console.log(e.detail.data.user_data);
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