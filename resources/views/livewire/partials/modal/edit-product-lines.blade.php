<form method="POST" action="{{ route('content.edit.section.product_line') }}" enctype="multipart/form-data">
    @csrf
    <div class="flex flex-col flex-wrap items-start justify-center gap-4">
        <input type="hidden" name="product_id" value="{{ $data['product']['id'] }}" />

        {{-- Name & Visibility --}}
        <section class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start w-full">
            <div class="w-full flex flex-col gap-1">
                <label for="input_productLineName" class="text-sm font-medium">Name</label>
                <input type="text" id="input_productLineName" name="product_line_name"
                    placeholder="Enter product line name..." required aria-required="true"
                    class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                    value="{{ $data['product']['name'] }}" />
            </div>

            <div class="w-full flex items-start justify-start gap-2">
                <x-public.switch_toggle id="input_visibility_2" name="visibility"
                    customStateValue="{{ $data['product']['visibility'] == 1 ?? false }}" size="xs"
                    label="Visible to public" labelPosition="top" />
            </div>
        </section>

        {{-- Image preview & upload --}}
        <section class="flex flex-wrap md:flex-nowrap items-start justify-center gap-4 w-full">
            <div class="w-full">
                <label class="text-sm font-medium">Image</label>
                <div class="w-full flex items-center justify-center p-4 hover:bg-gray-300 transition-colors">
                    <img src="{{ 'storage/' . $data['product']['image_path'] }}" alt="Product Image"
                        class="w-64 aspect-auto rounded-sm" />
                </div>
            </div>

            <div class="w-full flex items-start justify-start flex-col gap-1">
                <label class="text-sm font-medium">Upload image</label>
                <x-layouts.file_upload_drag required />
            </div>
        </section>

    </div>

    <section class="flex flex-wrap sm:flex-nowrap items-center justify-end gap-2 mt-4">
        <button type="button" @click="$dispatch('modal-close')"
            class="px-5 py-2 w-full sm:w-fit rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-darkslategray-300 bg-accent-darkslategray-200">
            Cancel
        </button>
        <button type="submit"
            class="px-5 py-2 w-full sm:w-fit rounded cursor-pointer flex items-center justify-center gap-1 text-gray-950 hover:bg-accent-orange-400 bg-accent-orange-300">
            @svg('fluentui-checkmark-16', 'w-5 h-5')
            Save Changes
        </button>
    </section>
</form>
