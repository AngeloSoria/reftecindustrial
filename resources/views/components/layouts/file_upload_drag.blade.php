@php
    $generatedId = uniqid('fileUpload_');
@endphp

@props([
    'privateUpload' => false,
    'uploadMultiple' => false,
    'action' => null,
    'hiddenData' => [], // ✅ supports multiple dynamic hidden inputs
    'renderHiddenInputs' => true, // ✅ whether to render <input type="hidden">
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
    {{-- ✅ Optional visible hidden inputs for debugging / form mirror --}}
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
        class="hidden"
    >

    <div class="text-center space-y-2 flex flex-col items-center justify-center gap-2">
        @svg('zondicon-upload', 'w-10 h-10 mx-auto text-gray-400')
        <p class="text-gray-700 font-semibold">Drag & drop files here</p>
        <p class="text-sm text-gray-500">or</p>
        <button type="button"
            @click="$refs.input.click()"
            class="flex items-center gap-2 cursor-pointer px-4 py-2 text-sm font-medium text-white bg-accent-orange-300 rounded hover:bg-accent-orange-400">
            @svg('fluentui-folder-20', 'w-5 h-5')
            Browse Files
        </button>
    </div>

    <!-- File list -->
    <template x-if="files.length > 0">
        <div class="mt-6 space-y-3">
            <template x-for="(file, index) in files" :key="file.name">
                <div
                    class="flex flex-col gap-2 p-3 border rounded bg-white shadow-sm"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <template x-if="file.preview">
                                <img :src="file.preview" class="w-12 h-12 object-cover rounded" />
                            </template>
                            <div>
                                <p class="text-sm font-medium text-gray-800" x-text="file.name"></p>
                                <p class="text-xs text-gray-500" x-text="(file.size/1024).toFixed(1) + ' KB'"></p>
                            </div>
                        </div>
                        <button type="button" class="text-sm text-red-600 hover:underline"
                            @click="removeFile(index)"
                            x-show="!file.uploading">Remove</button>
                    </div>

                    <template x-if="file.uploading">
                        <div class="w-full bg-gray-200 rounded h-2 overflow-hidden">
                            <div class="h-2 bg-green-500 transition-all duration-200"
                                :style="`width: ${file.progress}%;`"></div>
                        </div>
                    </template>

                    <template x-if="file.done">
                        <p class="text-xs text-green-600 font-medium">✅ Uploaded</p>
                    </template>

                    <template x-if="file.error">
                        <p class="text-xs text-red-600 font-medium">❌ Upload failed</p>
                    </template>
                </div>
            </template>
        </div>
    </template>

    <div class="mt-4 flex justify-end" x-show="files.length > 0">
        <button type="button" @click="uploadFiles()" :disabled="uploading"
            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded hover:bg-green-700 disabled:opacity-60">
            <span x-show="!uploading">Upload</span>
            <span x-show="uploading">Uploading...</span>
        </button>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('fileUploadHandler', (config) => ({
            files: [],
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
                    if (this.files.length > 0) {
                        const removed = this.files.pop();
                        if (removed?.preview) URL.revokeObjectURL(removed.preview);
                        setTimeout(() => {
                            this.files = [this.makeFileObj(newFiles[0])];
                        }, 300);
                    } else {
                        this.files = [this.makeFileObj(newFiles[0])];
                    }
                } else {
                    newFiles.forEach(file => this.files.push(this.makeFileObj(file)));
                }
            },

            makeFileObj(file) {
                return {
                    file,
                    name: file.name,
                    size: file.size,
                    preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
                    progress: 0,
                    uploading: false,
                    done: false,
                    error: false
                };
            },

            removeFile(index) {
                const removed = this.files.splice(index, 1)[0];
                if (removed?.preview) URL.revokeObjectURL(removed.preview);
            },

            resetFiles() {
                this.files.forEach(f => {
                    if (f.preview) URL.revokeObjectURL(f.preview);
                });
                this.files = [];
                this.uploading = false;
            },

            async uploadFiles() {
                if (!this.action) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { message: 'No upload endpoint provided.', type: 'error' }
                    }));
                    return;
                }

                if (this.files.length === 0) return;

                this.uploading = true;
                const uploads = this.files.map(f => this.uploadSingleFile(f));
                await Promise.all(uploads);
                this.uploading = false;

                const allDone = this.files.every(f => f.done);
                if (allDone) {
                    // ✅ Reload window so session flash toast will appear
                    window.location.reload();
                }
            },

            async uploadSingleFile(fileObj) {
                return new Promise((resolve) => {
                    const xhr = new XMLHttpRequest();
                    const formData = new FormData();

                    formData.append(this.multiple ? 'files[]' : 'file', fileObj.file);
                    formData.append('is_private', this.privateUpload ? 1 : 0);

                    // ✅ Add all hidden fields dynamically
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
                                fileObj.progress = 100;
                                // window.dispatchEvent(new CustomEvent('toast', {
                                //     detail: {
                                //         message: response?.message || `Uploaded: ${fileObj.name}`,
                                //         type: 'success',
                                //         refreshOnComplete: true
                                //     }
                                // }));
                            } else {
                                throw new Error(response.error || 'Upload failed');
                            }
                        } catch (err) {
                            fileObj.error = true;
                            // window.dispatchEvent(new CustomEvent('toast', {
                            //     detail: { message: err.message, type: 'error' }
                            // }));
                            console.error(message);
                        }
                        resolve();
                    };

                    xhr.onerror = () => {
                        fileObj.uploading = false;
                        fileObj.error = true;
                        // window.dispatchEvent(new CustomEvent('toast', {
                        //     detail: { message: 'Network error during upload.', type: 'error' }
                        // }));
                        console.error(message);
                        resolve();
                    };

                    xhr.send(formData);
                });
            }
        }));
    });
</script>
