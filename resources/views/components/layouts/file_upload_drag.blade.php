@props([
    'privateUpload' => false, // Default to private uploads
    'uploadMultiple' => false, // Allow multiple file uploads
    'action' => route('update.content.section.hero')
])

<div
    x-data="fileUploadHandler({
        multiple: {{ $uploadMultiple ? 'true' : 'false' }},
        privateUpload: {{ $privateUpload ? 'true' : 'false' }}
    })"
    x-on:drop.prevent="drop($event)"
    x-on:dragover.prevent="dragOver = true"
    x-on:dragleave.prevent="dragOver = false"
    class="relative w-full max-w-2xl p-6 border-2 border-dashed rounded-lg transition duration-200"
    :class="dragOver ? 'border-blue-400 bg-blue-50' : 'border-gray-300 bg-white hover:border-gray-400'"
>
    <input
        type="file"
        x-ref="input"
        x-on:change="filesAdded($event)"
        :multiple="multiple"
        class="hidden"
    >

    <div class="text-center space-y-2">
        @svg('zondicon-upload', 'w-10 h-10 mx-auto text-gray-400')

        <p class="text-gray-700 font-semibold">Drag & drop files here</p>
        <p class="text-sm text-gray-500">or</p>
        <button type="button"
            @click="$refs.input.click()"
            class="cursor-pointer px-4 py-2 text-sm font-medium text-white bg-accent-orange-300 rounded hover:bg-accent-orange-400">
            Browse Files
        </button>
    </div>

    <!-- File list -->
    <template x-if="files.length > 0">
        <div class="mt-6 space-y-3">
            <template x-for="(file, index) in files" :key="index">
                <div class="flex items-center justify-between p-3 border rounded">
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
                        @click="removeFile(index)">Remove</button>
                </div>
            </template>
        </div>
    </template>

    <!-- Upload button -->
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

            filesAdded(e) {
                const newFiles = Array.from(e.target.files);
                this.addFiles(newFiles);
                e.target.value = ''; // reset input for next drag/select
            },

            drop(e) {
                this.dragOver = false;
                const droppedFiles = Array.from(e.dataTransfer.files);
                this.addFiles(droppedFiles);
            },

            addFiles(newFiles) {
                // If single mode: replace existing file
                if (!this.multiple) {
                    this.clearPreviews();
                    const file = newFiles[0];
                    if (file) {
                        const preview = file.type.startsWith('image/') ? URL.createObjectURL(file) : null;
                        this.files = [{ file, name: file.name, size: file.size, preview }];
                    }
                } else {
                    // Multi mode: append
                    newFiles.forEach(file => {
                        const preview = file.type.startsWith('image/') ? URL.createObjectURL(file) : null;
                        this.files.push({ file, name: file.name, size: file.size, preview });
                    });
                }
            },

            removeFile(index) {
                const removed = this.files.splice(index, 1)[0];
                if (removed?.preview) URL.revokeObjectURL(removed.preview);
            },

            clearPreviews() {
                this.files.forEach(f => f.preview && URL.revokeObjectURL(f.preview));
                this.files = [];
            },

            async uploadFiles() {
                if (this.files.length === 0) return;
                this.uploading = true;

                const formData = new FormData();
                this.files.forEach(f => formData.append('files[]', f.file));
                formData.append('is_private', this.privateUpload ? 1 : 0);

                try {
                    const res = await fetch(@js($action), {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                        body: formData
                    });

                    if (res.ok) {
                        const data = await res.json();
                        toast(`Upload successful! (${data.is_private ? 'Private' : 'Public'})`, 'success');
                        this.clearPreviews();
                    } else {
                        const err = await res.json();
                        toast('Upload failed: ' + (err.error || 'Unknown error'), 'error');
                    }
                } catch (err) {
                    console.error(err);
                    toast('Upload error: ' + err.message, 'error');
                } finally {
                    this.uploading = false;
                }
            }
        }));
    });
</script>
