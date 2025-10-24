@php
    $generatedId = uniqid('fileUpload_');
@endphp

@props([
    'privateUpload' => false,
    'uploadMultiple' => false,
    'action' => null,
    'hiddenData' => [],
    'renderHiddenInputs' => true,
    'acceptFile' => null,
])

<div
    id="{{ $generatedId }}"
    x-data="fileUploadHandler({
        multiple: {{ $uploadMultiple ? 'true' : 'false' }},
        privateUpload: {{ $privateUpload ? 'true' : 'false' }},
        action: @js($action),
        hiddenData: @js($hiddenData)
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
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    @endif

    <input
        type="file"
        x-ref="input"
        x-on:change="filesAdded($event)"
        :multiple="multiple"
        @if(!empty($acceptFile)) accept="{{ $acceptFile }}" @else {{ 'dahek' }} @endif
        class="hidden"
    >

    <div class="text-center flex flex-col items-center gap-2">
        @svg('zondicon-upload', 'w-10 h-10 mx-auto text-gray-400')
        <p class="text-gray-700 font-semibold">Drag & drop files here</p>
        <p class="text-sm text-gray-500">or</p>
        <button
            type="button"
            @click="$refs.input.click()"
            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-accent-orange-300 rounded hover:bg-accent-orange-400"
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
                    <button type="button"
                        class="text-xs text-red-600 hover:underline"
                        @click="removeFile(index)">Remove</button>
                </div>
            </template>
        </div>
    </template>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('fileUploadHandler', (config) => ({
            files: [],
            uploadedData: [], // ✅ stores uploaded file info (e.g. from backend)
            dragOver: false,
            uploading: false,
            multiple: config.multiple ?? false,
            privateUpload: config.privateUpload ?? false,
            action: config.action,
            hiddenData: config.hiddenData ?? {},

            filesAdded(e) {
                const newFiles = Array.from(e.target.files);
                this.addFiles(newFiles);
                e.target.value = '';
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
            },

            makeFileObj(file) {
                return {
                    file,
                    name: file.name,
                    size: file.size,
                    preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
                    progress: 0,
                    done: false,
                    error: false,
                    response: null,
                };
            },

            removeFile(index) {
                const removed = this.files.splice(index, 1)[0];
                if (removed?.preview) URL.revokeObjectURL(removed.preview);
            },

            resetFiles() {
                this.files.forEach(f => f.preview && URL.revokeObjectURL(f.preview));
                this.files = [];
                this.uploadedData = [];
            },

            // ✅ Call this from your modal’s SAVE button
            async uploadFiles() {
                if (!this.action || this.files.length === 0) return [];

                this.uploading = true;
                const uploads = this.files.map(f => this.uploadSingleFile(f));
                await Promise.all(uploads);
                this.uploading = false;

                // ✅ Collect uploaded file responses (e.g. path, name)
                this.uploadedData = this.files
                    .filter(f => f.done && f.response)
                    .map(f => f.response);

                // ✅ Emit to parent (use Alpine’s dispatch)
                this.$dispatch('uploaded', { files: this.uploadedData });

                return this.uploadedData;
            },

            async uploadSingleFile(fileObj) {
                return new Promise((resolve) => {
                    const xhr = new XMLHttpRequest();
                    const formData = new FormData();

                    formData.append(this.multiple ? 'files[]' : 'file', fileObj.file);
                    formData.append('is_private', this.privateUpload ? 1 : 0);

                    for (const [key, value] of Object.entries(this.hiddenData)) {
                        formData.append(key, value);
                    }

                    fileObj.uploading = true;

                    xhr.open('POST', this.action, true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

                    xhr.upload.addEventListener('progress', (e) => {
                        if (e.lengthComputable) {
                            fileObj.progress = Math.round((e.loaded / e.total) * 100);
                        }
                    });

                    xhr.onload = () => {
                        fileObj.uploading = false;
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (xhr.status >= 200 && xhr.status < 300) {
                                fileObj.done = true;
                                fileObj.response = response; // ✅ store API response
                            } else {
                                fileObj.error = true;
                            }
                        } catch {
                            fileObj.error = true;
                        }
                        resolve();
                    };

                    xhr.onerror = () => {
                        fileObj.uploading = false;
                        fileObj.error = true;
                        resolve();
                    };

                    xhr.send(formData);
                });
            }
        }));
    });
</script>
