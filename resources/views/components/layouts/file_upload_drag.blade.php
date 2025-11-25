@props([
    'file_upload_id' => null,
    'privateUpload' => false,
    'multiple' => false,
    'hiddenData' => [],
    'renderHiddenInputs' => true,
    'acceptFile' => null,
    'required' => false,
    'maxUploadCount' => null,
    'id' => uniqid('fileUpload_'),
])

<div
    id="{{ $id }}"
    x-data="fileUploadHandler({
        file_upload_id: @js($file_upload_id),
        multiple: {{ $multiple ? 'true' : 'false' }},
        privateUpload: {{ $privateUpload ? 'true' : 'false' }},
        hiddenData: @js($hiddenData),
        maxUploadCount: {{ $maxUploadCount ? $maxUploadCount : 'null' }},
        inSubmissionPhase: false,
    })"
    @form_in_submit_phase.window="
        if($event.detail.file_upload_id !== file_upload_id) return;
        inSubmissionPhase = true;
    "
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
        class="hidden"
        x-ref="input"
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

        {{-- BUTTON DISABLED WHEN LIMIT REACHED --}}
        <button
            type="button"
            @click="openPicker()"
            class="cursor-pointer flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded
                hover:bg-accent-orange-400 bg-accent-orange-300 disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="isAtLimit"
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
        file_upload_id: config.file_upload_id ?? null,
        files: [],
        dragOver: false,
        multiple: config.multiple ?? false,
        privateUpload: config.privateUpload ?? false,
        maxUploadCount: config.maxUploadCount ?? null,
        inSubmissionPhase: config.inSubmissionPhase,

        async init() {
            window.addEventListener('reset_file_upload', (e) => {
                const detail = e.detail;
                // Check if detail exists
                if (!detail) {
                    console.warn('detail does not exist.');
                    return; // exit listener
                }

                
                // Check if detail has length (array/string) and is empty
                if ((detail.length !== undefined) && detail.length <= 0) {
                    console.warn('detail exists but is empty.');
                    return;
                }

                // Check if file_upload_id exists
                if (!detail.file_upload_id) {
                    console.warn('fileUploadID does not exist in detail.');
                    return;
                }
                
                // Check if file_upload_id matches this component's id
                if (detail.file_upload_id !== this.file_upload_id) {
                    // console.warn('file_upload_id does not match.');
                    // console.log(`file_upload_id: ${detail.file_upload_id} \nid: ${this.file_upload_id}`)
                    return;
                }

                // All checks passed → call resetFiles
                this.resetFiles();
            });

            // Watch for files array changes
            this.$watch('files', (newVal) => {
                if (!newVal || newVal.length === 0) {
                    // console.log('No files selected');
                    window.dispatchEvent(new CustomEvent('files_empty', {
                        detail: {
                            file_upload_id: this.file_upload_id
                        }
                    }));
                } else {
                    // Optional: dispatch an event when files exist
                    window.dispatchEvent(new CustomEvent('files_not_empty', {
                        detail: { file_upload_id: this.file_upload_id, files: newVal }
                    }));
                }
            });

        },

        get isAtLimit() {
            // For multiple uploads: limit by maxUploadCount
            if (this.multiple) {
                return this.maxUploadCount && this.files.length >= this.maxUploadCount;
            }

            // For single upload: disable if one file is already selected
            return !this.multiple && this.files.length >= 1;
        },


        notifyLimit() {
            toast(`Maximum of ${this.maxUploadCount} files allowed.`, 'warning');
        },

        // ✅ DUPLICATE DETECTION
        isDuplicate(file) {
            return this.files.some(f =>
                f.name === file.name &&
                f.size === file.size &&
                f.file.lastModified === file.lastModified
            );
        },

        openPicker() {
            if(this.inSubmissionPhase) return;
            if (this.isAtLimit) {
                this.notifyLimit();
                return;
            }
            this.$refs.input.click();
        },

        filesAdded(e) {
            const newFiles = Array.from(e.target.files);
            this.addFiles(newFiles);
        },

        drop(e) {
            this.dragOver = false;
            const droppedFiles = Array.from(e.dataTransfer.files);
            this.addFiles(droppedFiles);
        },

        addFiles(newFiles) {
            if(this.inSubmissionPhase) return;
            if (!this.multiple) {
                this.resetFiles();
                const f = newFiles[0];

                if (this.isDuplicate(f)) {
                    toast(`"${f.name}" is already selected.`, "warning");
                    return;
                }

                if (!this.isValidType(f)) {
                    toast(`Invalid file selected: "${f.name}".`, "warning");
                    return;
                }

                this.files = [this.makeFileObj(f)];
            } else {
                newFiles.forEach(f => {

                    if (this.isDuplicate(f)) {
                        toast(`"${f.name}" is already selected.`, "warning");
                        return;
                    }

                    if (!this.isValidType(f)) {
                        toast(`Invalid file selected: "${f.name}".`, "warning");
                        return;
                    }

                    if (!this.canAddMoreFiles()) {
                        this.notifyLimit();
                        return;
                    }

                    this.files.push(this.makeFileObj(f));
                });
            }

            this.syncInputFiles();
        },


        canAddMoreFiles() {
            if (!this.maxUploadCount) return true;
            return this.files.length < this.maxUploadCount;
        },

        acceptedTypes() {
            const accept = this.$refs.input.getAttribute('accept');
            if (!accept) return [];

            return accept.split(',').map(a => a.trim());
        },

        isValidType(file) {
            const rules = this.acceptedTypes();
            if (rules.length === 0) return true; // no restriction

            return rules.some(rule => {
                // file extension rule: .png, .jpg, .pdf
                if (rule.startsWith('.')) {
                    return file.name.toLowerCase().endsWith(rule.toLowerCase());
                }

                // mime wildcard: image/*, video/*
                if (rule.endsWith('/*')) {
                    const typePrefix = rule.replace('/*', '');
                    return file.type.startsWith(typePrefix);
                }

                // exact mime type: image/png, application/pdf
                return file.type === rule;
            });
        },

        makeFileObj(file) {
            return {
                file,
                name: file.name,
                size: file.size,
                preview: file.type.startsWith('image/')
                    ? URL.createObjectURL(file)
                    : null,
            };
        },

        removeFile(index) {
            if(this.inSubmissionPhase) return;
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
            if(this.inSubmissionPhase) return;
            this.files.forEach(f => f.preview && URL.revokeObjectURL(f.preview));
            this.files = [];
            if(this.$refs.input) {
                this.$refs.input.value = '';
            }
        },

    }));
});
</script>

