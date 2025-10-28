@php
    $generatedId = uniqid('fileUpload_');
@endphp

@props([
    'privateUpload' => false,
    'multiple' => false,
    'hiddenData' => [],
    'renderHiddenInputs' => true,
    'acceptFile' => null,
    'required' => false,
])

<div
    id="{{ $generatedId }}"
    x-data="fileUploadHandler({
        multiple: {{ $multiple ? 'true' : 'false' }},
        privateUpload: {{ $privateUpload ? 'true' : 'false' }},
        hiddenData: @js($hiddenData),
    })"
    x-on:drop.prevent="drop($event)"
    x-on:dragover.prevent="dragOver = true"
    x-on:dragleave.prevent="dragOver = false"
    class="relative w-full max-w-2xl p-6 border-2 border-dashed rounded-lg transition duration-200 {{ $attributes->get('class') }}"
    :class="dragOver ? 'border-blue-400 bg-blue-50' : 'border-gray-300 bg-white hover:border-gray-400'"
>
    {{-- Optional hidden inputs --}}
    @if($renderHiddenInputs && !empty($hiddenData))
        @foreach($hiddenData as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}" autocomplete="off" skip>
        @endforeach
    @endif

    <input
        type="file"
        x-ref="input"
        class="hidden"
        x-on:change="filesAdded($event)"
        @if(!empty($acceptFile)) accept="{{ $acceptFile }}" @endif
        @if ($multiple ?? false)
            multiple name="files[]"
        @else
            name="file"
        @endif

        @if($required ?? false) required @endif
    >

    <div class="text-center flex flex-col items-center gap-2">
        @svg('zondicon-upload', 'w-10 h-10 mx-auto text-gray-400')
        <p class="text-gray-700 font-semibold">Drag & drop files here</p>
        <p class="text-sm text-gray-500">or</p>
        <button
            type="button"
            @click="$refs.input.click()"
            class="cursor-pointer flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-accent-orange-300 rounded hover:bg-accent-orange-400"
        >
            @svg('fluentui-folder-20', 'w-5 h-5')
            Browse Files
        </button>
    </div>

    <!-- File list -->
    <template x-if="files.length > 0">
        <div class="mt-4 space-y-3">
            <template x-for="(file, index) in files" :key="file.name">
                <div class="flex items-center justify-between border rounded p-2 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <template x-if="file.preview">
                            <img :src="file.preview" class="w-10 h-10 object-cover rounded" />
                        </template>
                        <div>
                            <p class="text-sm font-medium text-gray-800" x-text="file.name"></p>
                            <p class="text-xs text-gray-500" x-text="(file.size/1024).toFixed(1) + ' KB'"></p>
                        </div>
                    </div>
                    <button
                        type="button"
                        title="Remove item"
                        class="text-xs text-red-600 hover:underline cursor-pointer"
                        @click="removeFile(index)"
                    >Remove</button>
                </div>
            </template>
        </div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('fileUploadHandler', (config) => ({
        files: [],
        dragOver: false,
        multiple: config.multiple ?? false,
        privateUpload: config.privateUpload ?? false,

        init() {
            // Allows external reset trigger (e.g., modal close)
            this.$el.addEventListener('reset-file-upload', () => this.resetFiles());
        },

        filesAdded(e) {
            const newFiles = Array.from(e.target.files);
            this.addFiles(newFiles);
            // e.target.value = ''; // allow reselecting same file
        },

        drop(e) {
            this.dragOver = false;
            const droppedFiles = Array.from(e.dataTransfer.files);
            this.addFiles(droppedFiles);
        },

        addFiles(newFiles) {
            if (!this.multiple) {
                this.resetFiles();
                this.files = [this.makeFileObj(newFiles[0])];
            } else {
                newFiles.forEach(f => this.files.push(this.makeFileObj(f)));
            }
            this.syncInputFiles();
        },

        makeFileObj(file) {
            return {
                file,
                name: file.name,
                size: file.size,
                preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
            };
        },

        removeFile(index) {
            const removed = this.files.splice(index, 1)[0];
            if (removed?.preview) URL.revokeObjectURL(removed.preview);
            this.syncInputFiles();
        },

        syncInputFiles() {
            const dt = new DataTransfer();
            this.files.forEach(f => dt.items.add(f.file));
            this.$refs.input.files = dt.files;
        },

        resetFiles() {
            this.files.forEach(f => f.preview && URL.revokeObjectURL(f.preview));
            this.files = [];
            this.$refs.input.value = '';
        },

        isFileContentsEmpty() {
            return (this.files.length() == 0);
        },
    }));
});
</script>
