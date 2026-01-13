<x-layouts.auth.app viewName="User Profile">
    <section class="bg-white rounded-xl shadow-xl p-6 min-h-[85vh] my-4 flex flex-col">
        <div>
            <p class="text-xl font-medium">Account Details</p>
        </div>

        <form
        class="grow flex flex-col"
        x-data="accountHandler()"
        @submit.prevent="handleSubmit"
        method="POST"
        action="{{ route('user.update') }}"
        >
            @csrf
            <input type="hidden" name="id" x-bind:="copyAccountData.id"/>
            <section class="mt-6 flex flex-col gap-4 grow">
                <section class="grid grid-cols-2 gap-4 max-w-2xl">
                    <div>
                        <p class="text-sm font-light mb-1">Name</p>
                        <x-form.input name="account_name" model="copyAccountData.name"/>
                    </div>
                    <div>
                        <p class="text-sm font-light mb-1">Username</p>
                        <x-form.input name="account_username" model="copyAccountData.username"/>
                    </div>
                </section>
                <section class="grid grid-cols-2 gap-4 max-w-2xl">
                    <div>
                        <p class="text-sm font-light mb-1">Role</p>
                        <select
                            x-model="copyAccountData.role"
                            @change="updateButtonState()"
                            class="w-full px-4 py-2 rounded border-2 border-gray-200" 
                            name="account_role" 
                            required>
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

            <section class="mt-4 flex gap-4">
                <button 
                    type="submit"
                    x-bind:disabled="!isNewDataApplied || isSubmitting"
                    title="Save details"
                    class="cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 bg-accent-orange-300 hover:bg-accent-orange-200 active:bg-accent-orange-400 transition-colors text-gray-800
                    flex items-center justify-center gap-2 rounded-sm px-4 py-2 w-fit">
                    <template x-if="isSubmitting">
                        @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                    </template>
                    <template x-if="!isSubmitting">
                        @svg('fluentui-edit-20', 'w-5 h-5')
                    </template>
                    <span x-text="isSubmitting ? 'Updating...' : 'Save Changes'"></span>
                </button>
                <button
                    @click="copyOrigin()"
                    type="button"
                    x-bind:disabled="!isNewDataApplied || isSubmitting"
                    title="Reset form"
                    class="cursor-pointer disabled:cursor-not-allowed bg-gray-300 hover:bg-gray-200 active:bg-gray-400 disabled:opacity-50 transition-colors text-gray-800 shdaow-card
                    flex items-center justify-center gap-2 rounded-sm px-4 py-2 w-fit">
                    Reset
                </button>
            </section>
        </form>
    </section>
    <script>
        function accountHandler() {
            return {
                accountData: {
                    id: @js(auth()->check() ? auth()->user()->id : ''),
                    name: @js(auth()->check() ? auth()->user()->name : ''),
                    username: @js(auth()->check() ? auth()->user()->username : ''),
                    role: @js(auth()->check() ? auth()->user()->role : ''),
                },
                copyAccountData: null,
                isNewDataApplied: false,
                isSubmitting: false,

                async init() {
                    console.log(this.accountData);
                    
                    this.copyOrigin();

                    console.log(this.copyAccountData)
                    console.log('isEqual: ' + this.isEqual(this.accountData, this.copyAccountData));
                },

                copyOrigin() {
                    this.copyAccountData = JSON.parse(JSON.stringify(this.accountData));
                    this.updateButtonState();
                },

                isEqual(a, b) {
                    return Object.keys(a).every(key => a[key] === b[key]);
                },

                updateButtonState() {
                    this.isNewDataApplied = !this.isEqual(this.accountData, this.copyAccountData);
                },

                handleSubmit() {
                    if (!this.isNewDataApplied || this.isSubmitting) return;
                    this.isSubmitting = true;
                    this.$el.submit();
                },
            };
        }
    </script>
</x-layouts.auth.app>


